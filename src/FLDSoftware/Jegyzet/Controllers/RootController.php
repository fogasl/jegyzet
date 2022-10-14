<?php

namespace FLDSoftware\Jegyzet\Controllers;

use FLDSoftware\Http;
use FLDSoftware\WebApp\WebApplicationBase;

class RootController extends JegyzetControllerBase {

    public function __construct(WebApplicationBase $context = null) {
        parent::__construct($context);
    }

    public function urls() {
        return array(
            array("GET", "/", "getIndex"),
            array("GET", "/main", "getMain")
        );
    }

    public function validation() {
        return array(
            "getIndex" => array(
                "query" => array(),
                "body" => array()
            )
        );
    }

    public function authentication() {
        return array(
            "getIndex" => null
        );
    }

    public function middlewares() {
        return array(
            "getIndex" => array(
                "before" => array(),
                "after" => array()
            )
        );
    }

    /**
     * HTTP endpoint handler for GET /
     * @param \FLDSoftware\Http\Request $request
     * @param \FLDSoftware\Http\ResponseHandler $handler
     * @return \FLDSoftware\Http\ResponseHandler
     */
    public function getIndex(Http\Request $request, Http\ResponseHandler $handler) {
        // Check session
        // not signed in -> redirect to the GET /signin endpoint
        // signed in -> redirect to the GET /main endpoint
        return $handler->redirect("/signin");
    }

    /**
     * HTTP endpoint handler for GET /main
     * @param \FLDSoftware\Http\Request $request
     * @param \FLDSoftware\Http\ResponseHandler $handler
     * @return \FLDSoftware\Http\ResponseHandler
     */
    public function getMain(Http\Request $request, Http\ResponseHandler $handler) {
        // Render full layout
        // left sidebar: notebooks in hierarchical order
        // right sidebar: top: title and actions bar
        // middle: card view of recently added/edited notes
        // bottom: format buttons, status bar
        return $handler->smarty(
            $this->getView("Main", "index.tpl"),
            array(
                "appName" => $this->context->appData->name,
                "now" => (new \DateTime())->format("Y-m-d")
            )
        );
    }
}
