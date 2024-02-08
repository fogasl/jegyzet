<?php

namespace FLDSoftware\Jegyzet\Controllers;

use FLDSoftware\Http;

class NotebookController extends JegyzetControllerBase {

    public function __construct($context = null) {
        parent::__construct($context);
    }

    public function urls() {
        return array(
            array("GET", "/notebooks", "getNotebooks"),
            array("GET", "/notebook/{id}", "getNotebook"),

            // Update notebook
            array("POST", "/notebook", "postNotebook"),

            // Add new notebook
            array("PUT", "/notebook", "putNotebook"),

            // Remove notebook
            array("DELETE", "/notebook", "deleteNotebook")
        );
    }

    public function getNotebooks(Http\Request $request, Http\ResponseHandler $handler) {
        return $handler->jsonp(array("foo" => null));
    }

    public function getNotebook(Http\Request $request, Http\ResponseHandler $handler) {
        return $handler->json(null);
    }

}
