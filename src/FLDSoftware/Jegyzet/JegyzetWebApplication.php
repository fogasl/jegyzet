<?php

namespace FLDSoftware\Jegyzet;

use FLDSoftware\Config\ConfigBase;
use FLDSoftware\Facade;
use FLDSoftware\Http;
use FLDSoftware\WebApp;

/**
 * The main **Jegyzet** web application that ties controllers and URL routes
 * together.
 */
class JegyzetWebApplication extends WebApp\WebApplicationBase {

    // FIXME: move to parent class to allow some kind of
    // automatic URL-Controller::method mapping
    const PATHINFO_REGEX = "^\/(?:(?<controller>[\w+\-\_]+)([\/](?<action>[\w\-\_]+)?([\/](?<id>[\w+\-\_]+))*)*)$";

    /**
     * Reference to the Facade instance that performs business logic.
     * @var \FLDSoftware\Facade\FacadeBase
     */
    public $facade;

    /**
     * Initialize the application.
     * @param \FLDSoftware\WebApp\Config\AppData $appData Application manifest data
     * @param \FLDSoftware\Config\ConfigBase $config Application configuration
     * @param \FLDSoftware\Facade\FacadeBase $facade Application facade
     */
    public function __construct(WebApp\Config\AppData $appData, ConfigBase $config, Facade\FacadeBase $facade) {
        parent::__construct($appData, $config);

        $this->facade = $facade;
    }

    protected function setupControllers() {
        $this->mount(Controllers\RootController::class, $this);
        $this->mount(Controllers\SessionController::class, $this);
        $this->mount(Controllers\NotebookController::class, $this);
        // TODO: add all controllers
    }

    protected function setupApiControllers() {
        // $this->mount(Controllers\SessionApiController::class, $this);
    }

    /**
     * Perform web application setup.
     * Set the appropriate HTTP request and response handlers, add cookie and
     * request body parsers, and add controllers with their URL configurations.
     */
    public function setup() {
        // Set request handler
        $this->requestHandler = new Http\RequestHandler();
        $this->requestHandler->setLogger($this->logger);

        // Set request dispatcher
        $this->requestDispatcher = new WebApp\Http\RequestDispatcher(
            $this,
            WebApp\Http\RequestDispatcher::IGNORE_DIRECT_OUTPUT |
            WebApp\Http\RequestDispatcher::IGNORE_TRAILING_SLASH |
            WebApp\Http\RequestDispatcher::CASE_INSENSITIVE_ROUTING
        );

        // Setup parsers

        $jsonBodyParser = new Http\Parsers\JsonBodyParser();
        $jsonBodyParser->setLogger($this->logger);

        $urlEncodedBodyParser = new Http\Parsers\UrlEncodedBodyParser();
        $urlEncodedBodyParser->setLogger($this->logger);

        $cookieParser = new Http\Parsers\CookieParserBase();
        $cookieParser->setLogger($this->logger);

        // Add body and cookie parsers for various payloads
        $this->requestHandler->addBodyParser($jsonBodyParser);
        $this->requestHandler->addBodyParser($urlEncodedBodyParser);
        $this->requestHandler->addCookieParser($cookieParser);

        // Set response handler to the one that implements Smarty rendering
        $responseHandler = new WebApp\Http\SmartyResponseHandler(
            $this
        );
        $responseHandler->setLogger($this->logger);

        $this->responseHandler = $responseHandler;

        // Mount controllers
        $this->setupControllers();
        $this->setupApiControllers();
    }

}
