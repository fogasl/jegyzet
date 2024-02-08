<?php

namespace FLDSoftware\Jegyzet\Controllers;

use FLDSoftware\Http\Request;
use FLDSoftware\Http\ResponseHandler;
use FLDSoftware\WebApp\WebApplicationBase;

/**
 * Handling sign-in and sign-out operations.
 */
class SessionController extends JegyzetControllerBase {

    const SESSION_COOKIE_NAME = "jgysession";

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
        // FIXME figure out reasonable parameterizing
        return array(
            "getIndex" => "WebAppAuthentication::basicHttp(foo, bar)"
        );
    }

    // GET /signin
    public function getIndex(Request $request, ResponseHandler $handler): ResponseHandler {
        try {
            foreach ($request->cookies as $cookie) {
                $this->logWarning("Cookie", $cookie->__toString());
            }
        } catch (\Exception $ex) {
        }

        return $handler;
    }

    public function postIndex(Request $request, ResponseHandler $handler): ResponseHandler {
        try {
            $this->context->facade->session->signIn(
                $request->body["username"],
                $request->body["password"]
            );
        } catch (\Exception $ex) {

        } finally {
            return $handler;
        }
    }

    public function getSignout(Request $request, ResponseHandler $handler): ResponseHandler {
        throw new \Exception("Not Implemented");
    }

}
