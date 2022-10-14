<?php

namespace FLDSoftware\WebApp;

use FLDSoftware\Config\ConfigBase;
use FLDSoftware\Http;
use FLDSoftware\Logging\Loggable;
use FLDSoftware\WebApp\Config;
use FLDSoftware\WebApp\Controllers\ControllerBase;
use FLDSoftware\WebApp\Http\RequestDispatcher;

/**
 * Base class for applications.
 */
class WebApplicationBase extends Loggable {

    /**
     * Application descriptor data container.
     * @var \FLDSoftware\WebApp\Config\AppData
     */
    public $appData;

    /**
     * Mapping URLs to Controller instances.
     * @var array
     */
    public $urlMap;

    /**
     * Application configuration.
     * @var \FLDSoftware\Config\ConfigBase
     */
    public $config;

    /**
     * HTTP request handler instance.
     * @var \FLDSoftware\Http\RequestHandler
     */
    public $requestHandler;

    /**
     * HTTP response handler instance.
     * @var \FLDSoftware\Http\ResponseHandler
     */
    public $responseHandler;

    /**
     * Request dispatcher instance.
     * @var \FLDSoftware\WebApp\Http\RequestDispatcher
     */
    public $requestDispatcher;

    /**
     * Initialize the application.
     * @param \FLDSoftware\WebApp\Config\AppData $appData Application descriptor data such as app name and so.
     * @param \FLDSoftware\Config\ConfigBase $config Application configuration.
     */
    public function __construct(Config\AppData $appData = null, ConfigBase $config = null) {
        $this->appData = $appData;
        $this->config = $config;
        $this->urlMap = array();
    }

    /**
     * Returns a string that represents the application.
     * @return string String representation of the application.
     */
    public function __toString() {
        return \sprintf(
            "%s v%s",
            $this->appData->name,
            $this->appData->version
        );
    }

    /**
     * Attach application HTTP endpoint URLs to controller instances.
     * @param string $controllerClass Fully-qualified name of the controller class to mount.
     * @param object $context Controller context (usually reference to the enclosing WebApplicationBase instance or its subclass)
     * @throws \Exception Controller is not inherited from ControllerBase.
     */
    public function mount(string $controllerClass, object $context) {
        $this->logDebug("Mounting %s", $controllerClass);

        if (!\is_subclass_of($controllerClass, ControllerBase::class)) {
            throw new Errors\WebAppException(
                \sprintf(
                    "%s is not inherited from %s",
                    $controllerClass,
                    ControllerBase::class
                )
            );
        }

        // Initialize the controller
        $controller = new $controllerClass($context);

        // Set logging
        $controller->setLogger($this->logger);

        // Retrieve mount points
        $urls = $controller->urls();

        // Store mount points and options
        foreach ($urls as $url) {
            if (\count($url) < 3) {
                throw new Errors\WebAppException(
                    \sprintf(
                        "%s: urls should have the following properties: %s, %s, %s",
                        $controllerClass,
                        "httpMethod", "endpoint", "controllerMethod"
                    )
                );
            }

            $httpMethod = $url[0];
            $endpoint = $url[1];
            $controllerMethod = $url[2];

            if (!(\array_key_exists($httpMethod, $this->urlMap))) {
                $this->urlMap[$httpMethod] = array();
            }

            $this->urlMap[$httpMethod][$endpoint] = array(
                $controller,
                $controllerMethod
            );
        }

        return $this;
    }

    /**
     * Perform the complete HTTP request cycle handling.
     * @param array $server
     */
    public function handleRequest(array $server) {
        try {
            // Create internal Request instance from raw HTTP request (parse
            // cookies and request body if necessary)
            $request = $this->requestHandler->handleRequest($server);

            $this->logDebug(
                "Request: %s",
                $request
            );

            // Handle early HTTP errors (cookie or body parsing errors,
            // unsupported content types, etc.)
            if ($request->response !== null && $request->response->getError() !== null) {
                $err = $request->response->getError();

                $this->logMajor(
                    "Early error in request handling: %s",
                    $err
                );

                throw $err;
            }

            // Dispatch request to the controller and let it do the rest
            $responseHandler = $this->requestDispatcher->dispatch($request);
        } catch (\Throwable $error) {
            // Handle errors
            $responseHandler = $this->handleError($error);
        } finally {
            // Send HTTP status header to the client
            $responseHandler->sendStatus();

            // Send HTTP headers
            $responseHandler->sendHeaders();

            // Send cookies
            $responseHandler->sendCookies();

            // Send payload
            $responseHandler->sendBody();
        }
    }

    /**
     * Handle unexpected errors in the request handling phase.
     * Subclasses may overload this method to implement their own error
     * handling mechanisms.
     * @param \Throwable $exception
     * @param \FLDSoftware\Http\Request $request
     */
    public function handleError(\Throwable $exception, Http\Request $request = null) {
        $handler = new Http\ResponseHandler();

        $handler->response->setStatus(500);
        // TODO: \FLDSoftware\Http\Header::contentType("text/plain");
        $handler->response->setHeader("Content-Type", "text/plain; charset=utf-8");
        $handler->response->setBody(
            \sprintf(
                "%s: %s %s %s",
                \get_class($exception),
                $exception->getMessage(),
                \PHP_EOL,
                $exception->getTraceAsString()
            )
        );

        return $handler;
    }

    /**
     * Perform web application setup.
     * In this implementation, basic `RequestHandler`, `RequestDispatcher` and
     * `ResponseHandler` instances are attached.
     * Subclasses may (and should) overload this method to implement their own
     * HTTP cycle handling and output rendering mechanisms.
     */
    public function setup() {
        $this->requestHandler = new Http\RequestHandler();
        $this->requestDispatcher = new RequestDispatcher($this);
        $this->responseHandler = new Http\ResponseHandler($this);
    }

}
