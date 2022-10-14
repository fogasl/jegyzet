<?php

namespace FLDSoftware\Config;

use FLDSoftware\Pathlib\Path;

/**
 * Configuration file loader that loads PHP files as configuration.
 * Use this class when application configuration is treated differently
 * across multiple environments.
 * Environment name is the base of config file name.
 */
class EnvironmentalConfigLoader extends ConfigLoader {

    /**
     * Initialize a new instance of the `EnvironmentalConfigLoader` class.
     * @param \FLDSoftware\Pathlib\Path $baseDir Base directory of configuration files
     * @param string $cls Fully qualified path of the class to parse config results to
     */
    public function __construct(Path $baseDir, string $cls) {
        parent::__construct($baseDir, $cls);
    }

    /**
     * Load configuration from file.
     * @param string $environment Environment name in which the application runs
     * @return mixed
     * @throws \FLDSoftware\Pathlib\PathException Config file does not exist
     */
    public function load(string $environment) {
        // TODO More thorough error handling!
        $fn = $environment . ".conf.php";
        return parent::load($fn);
    }

}
