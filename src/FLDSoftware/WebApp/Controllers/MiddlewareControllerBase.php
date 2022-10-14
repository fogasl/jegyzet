<?php

namespace FLDSoftware\WebApp\Controllers;

use FLDSoftware\WebApp\WebApplicationBase;

class MiddlewareControllerBase extends ControllerBase {

    public function __construct(WebApplicationBase $context = null) {
        parent::__construct($context);
    }

}
