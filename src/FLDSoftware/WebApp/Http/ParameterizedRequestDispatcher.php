<?php

namespace FLDSoftware\WebApp\Http;

use FLDSoftware\WebApp;
use FLDSoftware\Http;

class ParameterizedRequestDispatcher extends RequestDispatcher {

    public function __construct(WebApp\WebApplicationBase $context, int $flags = 0) {
        parent::__construct($context, $flags);
    }

    public function dispatch(Http\Request $request) {
        throw new \Exception("Not Implemented");
    }

}
