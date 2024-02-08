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

        // TODO may use env vars instead, in the following fashion:
        // JEGYZET_BASE_URL = ""
        // JEGYZET_DEBUG = false
        // JEGYZET_SMARTY_TEMPLATE_DIR = ""
        // JEGYZET_SMARTY_COMPILE_DIR = ""
        // JEGYZET_SMARTY_CACHE_DIR = ""
        // JEGYZET_SMARTY_CONFIG_DIR = ""
        // JEGYZET_EMAIL_ENABLED = 0
        // JEGYZET_EMAIL_SMTP_HOST = "mail.mymta.local"
        // JEGYZET_EMAIL_SMTP_PORT = "25"
        // JEGYZET_EMAIL_SMTP_TLS = "STARTTLS" ???
        // JEGYZET_EMAIL_SMTP_USER = "mailer"
        // JEGYZET_EMAIL_SMTP_PASSWORD = "foobarbaz"

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
