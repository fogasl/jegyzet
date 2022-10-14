<?php

namespace FLDSoftware\WebApp\Controllers;

use FLDSoftware\Logging\Loggable;
use FLDSoftware\WebApp\WebApplicationBase;

/**
 * Base class for controllers.
 */
abstract class ControllerBase extends Loggable {

    const MW_BEFORE = 1;

    const MW_AFTER = 2;

    /**
     * Reference to the enclosing web application instance.
     * @var \FLDSoftware\WebApp\WebApplicationBase
     */
    protected $context;

    /**
     * Initialize a new instance of the `ControllerBase` class.
     * @param \FLDSoftware\WebApp\WebApplicationBase $context Application context
     */
    public function __construct(WebApplicationBase $context = null) {
        $this->context = $context;
    }

    /**
     * When implemented in a derived class, returns array containing URL
     * mappings.
     * @return array
     */
    public function urls() {
        return array();
    }

    /**
     * When implemented in a derived class, returns array containing validation
     * rules for controller methods.
     * @return array
     */
    public function validation() {
        return array();
    }

    /**
     * When implemented in a derived class, returns array containing
     * authentication rules for controller methods.
     * @return array
     */
    public function authentication() {
        return array();
    }

    /**
     * Returns a string that represents the controller instance.
     * @return string
     */
    public function __toString() {
        return \get_class($this);
    }

}
