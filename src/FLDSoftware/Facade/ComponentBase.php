<?php

namespace FLDSoftware\Facade;

use FLDSoftware\Config\ConfigBase;

/**
 * Base class for facade components.
 */
class ComponentBase {

    protected $config;

    public function __construct(ConfigBase $config) {
        $this->config = $config;
    }

}
