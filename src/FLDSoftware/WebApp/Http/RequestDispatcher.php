<?php

namespace FLDSoftware\WebApp\Http;

use FLDSoftware\Http;
use FLDSoftware\Logging\Loggable;
use FLDSoftware\WebApp;

/**
 * Basic request dispatcher.
 * FIXME: add logging to critical points
 */
class RequestDispatcher extends Loggable {

    /**
     * Ignore standard output emitted by the called controller methods
     * (e.g. via {@see \echo}, {@see \printf} and so on)
     * @var int
     */
    const IGNORE_DIRECT_OUTPUT = 1;

    /**
     * Ignore the trailing `"/"` character from the request path.
     * (e.g. `/foo/bar/` and `/foo/bar` are treated the same)
     * @var int
     */
    const IGNORE_TRAILING_SLASH = 2;

    /**
     * Redirect requests with trailing slash to their unslashed counterparts.
     * (e.g. `/foo/bar/` will be redirected to `/foo/bar`)
     * @var int
     */
    const TRAILING_SLASH_REDIRECT = 6;

    /**
     * Do not match case when searching for the path in the urlMap.
     * (e.g. `/foo/bar` and `/Foo/BAR` are treated the same)
     * @var int
     */
    const CASE_INSENSITIVE_ROUTING = 8;

    /**
     * Request dispatcher context (web application instance)
     * @var \FLDSoftware\WebApp\WebApplicationBase
     */
    protected $context;

    /**
     * Dispatch rule flags.
     * @var int
     */
    protected $flags;

    // FIXME: Return path component from the request
    protected function findEndpoint(Request $request) {
        return $this->context->urlMap;
    }

    /**
     * Initialize a new `RequestDispatcher` instance.
     * @param \FLDSoftware\WebApp\WebApplicationBase $context Dispatcher app context
     * @param int $flags Dispatch rule flags
     */
    public function __construct(WebApp\WebApplicationBase $context, int $flags = 0) {
        $this->context = $context;
        $this->flags = $flags;
    }

    /**
     * Dispatch request to the appropriate controller method.
     * 
     * In the basic RequestDispatcher, the dispatch process is the following:
     * 1. Find controller and method name in the urlMap of the context (that
     * is itself a reference to the enclosing web application instance)
     * 2. Call the method found in the previous step, passing request instance
     * and response handler to it.
     * 3. Controller method MUST return {@see \FLDSoftware\Http\ResponseHandler}
     * in which they can manipulate the `response` field.
     * 4. Return the response handler instance to the calling
     * {@see \FLDSoftware\WebApp\WebApplicationBase::handleRequest}.
     * 
     * @param \FLDSoftware\Http\Request $request HTTP request
     * @return \FLDSoftware\Http\ResponseHandler Response handler instance.
     * 
     * @throws \Exception Cannot find controller method for the given request
     * @throws \Exception Controller method does not return a
     * {@see \FLDSoftware\Http\ResponseHandler} instance.
     */
    public function dispatch(Http\Request $request) {
        // Determine whether the request path is root ("/") or not.
        // Root path must never be redirected when TRAILING_SLASH_REDIRECT is turned on
        $nonRootPath = \strlen($request->path) > 1;

        $lastSlashPos = \strrpos($request->path, "/");
        $hasLastSlash = $lastSlashPos === \strlen($request->path) - 1;

        if (($this->flags & self::IGNORE_TRAILING_SLASH) && $hasLastSlash && $nonRootPath) {
            $path = \substr($request->path, 0, $lastSlashPos);
        } else {
            $path = $request->path;
        }

        if ($this->flags & self::TRAILING_SLASH_REDIRECT && $hasLastSlash && $nonRootPath) {
            return $this->context->responseHandler->redirect(
                $path,
                301 // Moved permanently
            );
        }

        // Find handler in the urlMap
        // FIXME: implement case-insensitive path search
        if (!(\array_key_exists($request->method, $this->context->urlMap)) ||
            !(\array_key_exists($path, $this->context->urlMap[$request->method]))) {
            throw new WebApp\Errors\RouteNotFoundException(
                \sprintf(
                    "Cannot %s %s: no handler is associated with this path",
                    $request->method,
                    $path
                )
            );
        }

        // Extract controller instance and method name from the URL map
        list(
            $controller,
            $method
        ) = $this->context->urlMap[$request->method][$path];

        if (!(\method_exists($controller, $method))) {
            throw new WebApp\Errors\WebAppException(
                \sprintf("Method does not exist: %s::%s", $controller, $method)
            );
        }

        if ($this->flags & self::IGNORE_DIRECT_OUTPUT) {
            \ob_start();
        }

        // Here comes the magic
        $response = \call_user_func_array(
            array($controller, $method),
            array($request, $this->context->responseHandler)
        );

        if ($this->flags & self::IGNORE_DIRECT_OUTPUT) {
            \ob_end_clean();
        }

        if ($response === null) {
            throw new WebApp\Errors\WebAppException(
                \sprintf(
                    "%s::%s should return ResponseHandler instance",
                    $controller,
                    $method
                )
            );
        }

        return $response;
    }

}
