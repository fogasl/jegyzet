<?php

namespace FLDSoftware\Jegyzet\Config;

use FLDSoftware\Config\ConfigBase;
use FLDSoftware\Pathlib\Path;

/**
 * Represents the parsed contents of the web application config file.
 * Also contains default values as fallbacks for config entries.
 */
class JegyzetAppConfig extends ConfigBase {

    /**
     * Initialize a new instance of the `JegyzetAppConfig` class.
     * @param array $config Config file contents as associative array
     */
    public function __construct($config = array()) {

        $componentDir = new Path(__DIR__, "..");
        $viewsDir = new Path($componentDir, "Views");
        $baseDir = new Path($componentDir, "..", "..", "..");
        $cacheDir = new Path($baseDir, "cache");

        $defaults = array(
            "baseUrl" => "",

            "debug" => false,

            "smarty" => array(
                "templateDir" => $viewsDir,
                "compileDir" => new Path($cacheDir, "templates"),
                "cacheDir" => $cacheDir,
                "configDir" => null
            )
        );

        parent::__construct($config, $defaults);

    }

}
