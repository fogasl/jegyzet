<?php

namespace FLDSoftware\Config;

use FLDSoftware\Pathlib;

/**
 * Basic configuration file loader that loads PHP files as configuration.
 */
class ConfigLoader {

    /**
     * Base directory of configuration files.
     * @var \FLDSoftware\Pathlib\Path
     */
    protected $baseDir;

    /**
     * Fully qualified path of the class to parse config results to.
     * @var string
     */
    protected $cls;

    /**
     * Parse the configuration file contents (associative array) to the class
     * spacified.
     * Subclasses may override this method to implement their own class
     * initializer mechanisms.
     * @param array $config
     * @return mixed
     */
    protected function toClass(array $config) {
        $cls = ($this->cls);
        return new $cls($config);
    }

    /**
     * Initialize a new instance of the `ConfigLoader` class.
     * @param \FLDSoftware\Pathlib\Path $baseDir Base directory of configuration files
     * @param string $cls Fully qualified path of the class to parse config results to
     */
    public function __construct(Pathlib\Path $baseDir, string $cls) {
        $this->baseDir = $baseDir;
        $this->cls = $cls;
    }

    /**
     * Load configuration from file.
     * @param string $fileName Path of the configuration file.
     * @return mixed
     * @throws \FLDSoftware\Pathlib\PathException Config file does not exist
     */
    public function load(string $fileName) {
        $path = new Pathlib\Path($this->baseDir, $fileName);

        if (!($path->exists())) {
            throw new Pathlib\PathException(
                \sprintf(
                    "Config file does not exist: %s",
                    $path->getAbsolutePath()
                )
            );
        }

        // Load config file
        $conf = require $path;

        // Convert to class
        return $this->toClass($conf);
    }

}
