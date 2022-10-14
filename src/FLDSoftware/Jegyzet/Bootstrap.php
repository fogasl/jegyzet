<?php

namespace FLDSoftware\Jegyzet;

use FLDSoftware\Config\ConfigBase;
use FLDSoftware\Config\EnvironmentalConfigLoader;
use FLDSoftware\Logging;
use FLDSoftware\Http;
use FLDSoftware\Pathlib;
use FLDSoftware\Jegyzet\Components;

/**
 * Bootstrap the application.
 * Load configuration and components and prepare the application for run.
 */
class Bootstrap {

    /**
     * Default environment of the application.
     * @var string
     */
    public const DEFAULT_ENVIRONMENT = "production";

    // Do not allow initialization.
    private function __construct() {
    }

    /**
     * Gets the base directory of the project.
     * @return \FLDSoftware\Pathlib\Path
     */
    private static function _getBaseDir() {
        return new Pathlib\Path(__DIR__, "..", "..", "..");
    }

    /**
     * Gets the base directory of configuration files.
     * @return \FLDSoftware\Pathlib\Path
     */
    private static function _getConfigDir() {
        return new Pathlib\Path(self::_getBaseDir(), "conf");
    }

    /**
     * Configure the runtime environment of the application.
     */
    private static function setupRuntime() {
        \ini_set("error_reporting", \E_ALL);
        \ini_set("html_errors", "off");
    }

    /**
     * Retrieve application manifest data.
     * @param string $environment Name of the environment in which the
     * application runs.
     * @return \FLDSoftware\WebApp\Config\AppData
     */
    private static function setupAppData(string $environment) {
        $res = \FLDSoftware\WebApp\Config\AppData::fromComposerFile(
            self::_getBaseDir()
        );

        $res->environment = $environment;

        return $res;
    }

    /**
     * Load application configuration from file.
     * @param string $environment Name of the environment in which the
     * application runs.
     * @return \FLDSoftware\Jegyzet\Config\JegyzetAppConfig
     */
    private static function setupConfig(string $environment) {
        $loader = new EnvironmentalConfigLoader(
            self::_getConfigDir(),
            Config\JegyzetAppConfig::class
        );

        $cfg = $loader->load($environment);

        return $cfg;
    }

    /**
     * Create and configure application logger.
     * @param \FLDSoftware\Config\ConfigBase $config Application configuration
     * @return \FLDSoftware\Logging\LoggerBase
     */
    private static function setupLogging(ConfigBase $config) {
        $logger = new Logging\LoggerBase();

        // Set logging levels
        $logger->setLevel(
            Logging\LoggerBase::LOG_LEVEL_CRITICAL
            | Logging\LoggerBase::LOG_LEVEL_ERROR
            | Logging\LoggerBase::LOG_LEVEL_WARNING
            | Logging\LoggerBase::LOG_LEVEL_MAJOR
            | Logging\LoggerBase::LOG_LEVEL_MINOR
        );

        if ($config->getValue("debug")) {
            $logger->setLevel(Logging\LoggerBase::LOG_LEVEL_DEBUG);
        }

        // Add logging channels
        $logger->addChannel(
            new Logging\ConsoleLogChannel()
        );

        return $logger;
    }

    /**
     * Initialize the application facade.
     * @param \FLDSoftware\Config\ConfigBase $config
     * @return \FLDSoftware\Jegyzet\Facade
     */
    private static function setupFacade(ConfigBase $config) {
        $facade = new Facade($config);

        // TODO: register all facade components
        $facade->register("session", Components\SessionComponent::class);

        $facade->register("email", Components\EmailComponent::class);

        return $facade;
    }

    /**
     * Initialize the application.
     * @param string $environment Environment name.
     * @return \FLDSoftware\WebApp\WebApplicationBase Web application instance.
     */
    public static function setup(string $environment) {
        self::setupRuntime();

        $appData = self::setupAppData($environment);
        $config = self::setupConfig($environment);
        $logger = self::setupLogging($config);
        $facade = self::setupFacade($config);

        $app = new JegyzetWebApplication(
            $appData,
            $config,
            $facade
        );

        // Set logger
        $app->setLogger($logger);

        // Perform application setup
        $app->setup();

        return $app;
    }

}
