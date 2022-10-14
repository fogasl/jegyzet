<?php

namespace FLDSoftware\Jegyzet\Controllers;

use FLDSoftware\Http;
use FLDSoftware\WebApp\WebApplicationBase;

/**
 * Handling sign-in and sign-out operations.
 */
class SessionController extends JegyzetControllerBase {

    public function __construct(WebApplicationBase $context = null) {
        parent::__construct($context);
    }

    /**
     * Returns array of URL mappings.
     * @return array
     */
    public function urls() {
        return array(
            array("GET", "/signin", "getIndex"),
            array("POST", "/signin", "postIndex"),
            array("GET", "/signout", "getSignout")
        );
    }

    /**
     * Returns array of data validation rules.
     * @return array
     */
    public function validation() {
        return array(
            "getIndex" => array(
                "params" => array(),
                "query" => array(),
                "body" => array()
            )
        );
    }

    /**
     * Return array of authentication rules.
     * @return array
     */
    public function authentication() {
        return array(
            "getIndex" => "WebAppAuthentication::basicHttp(foo, bar)"
        );
    }

    public function getIndex(Http\Request $request, Http\ResponseHandler $handler) {
        try {
            $model = $this->context->facade->session->getSigninModel();

            return $handler->smarty(
                $this->getView("Session", "signin.tpl"),
                $model
            );
        } catch (\Throwable $err) {
            return $this->context->handleError($err, $request);
        }
    }

    public function postIndex(Http\Request $request, Http\ResponseHandler $handler) {
        $session = $this->context->facade->session->signin(
            $request->body["username"],
            $request->body["password"]
        );

        $res = array(
            "body" => $request->body,
            "query" => $request->query,
            "session" => $session
        );

        return $handler->json($res);
    }

    public function getSignout(Http\Request $request, Http\ResponseHandler $handler) {
        throw new \Exception("Not Implemented");
    }

}
