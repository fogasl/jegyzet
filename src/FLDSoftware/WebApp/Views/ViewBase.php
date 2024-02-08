<?php

namespace FLDSoftware\WebApp\Views;

/**
 * Represents a *view model* in the MVC application.
 * ViewBag that contains data to pass to the templates
 */
class ViewBase implements \Stringable {

    public function __construct() {

    }

    public function __toString(): string {
        return "";
    }

}
