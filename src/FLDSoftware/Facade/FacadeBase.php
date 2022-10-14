<?php

namespace FLDSoftware\Facade;

use FLDSoftware\Config\ConfigBase;

/**
 * Base class for application facades.
 */
class FacadeBase {

    /**
     * Application configuration.
     * @var \FLDSoftware\Config\ConfigBase
     */
    protected $_config;

    public function __construct(ConfigBase $config) {
        $this->_config = $config;
    }

    // FIXME: register by class only, determine property name by class name
    public function register($name, $component) {
        $this->$name = new $component($this->_config);
    }

}
