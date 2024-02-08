<?php

namespace FLDSoftware\Jegyzet;

use FLDSoftware\Config\ConfigBase;
use FLDSoftware\Config\EnvironmentalConfigLoader;
use FLDSoftware\Jegyzet\Config\JegyzetAppConfig;
use FLDSoftware\Jegyzet\Repository\JegyzetRepository;
use FLDSoftware\Logging\ConsoleLogChannel;
use FLDSoftware\Logging\LoggerBase;
use FLDSoftware\Pathlib\Path;
use FLDSoftware\Repository\RepositoryBase;
use FLDSoftware\WebApp\Authentication\Authentication;
use FLDSoftware\WebApp\Config\AppData;
use FLDSoftware\WebApp\WebApplicationBase;

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
    private static function _getBaseDir(): Path {
        return new Path(__DIR__, "..", "..", "..");
    }

    /**
     * Gets the base directory of configuration files.
     * @return \FLDSoftware\Pathlib\Path
     */
    private static function _getConfigDir(): Path {
        return new Path(self::_getBaseDir(), "conf");
    }

    /**
     * Configure the runtime environment of the application.
     */
    private static function setupRuntime(): void {
        \ini_set("error_reporting", \E_ALL);
        \ini_set("html_errors", "off");
    }

    /**
     * Retrieve application manifest data.
     * @param string $environment Name of the environment in which the
     * application runs.
     * @return \FLDSoftware\WebApp\Config\AppData
     */
    private static function setupAppData(string $environment): AppData {
        $res = AppData::fromComposerFile(
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
    private static function setupConfig(string $environment): JegyzetAppConfig {
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
    private static function setupLogging(ConfigBase $config): LoggerBase {
        $logger = new LoggerBase();

        // Set logging levels
        $logger->setLevel(
            LoggerBase::LOG_LEVEL_CRITICAL
            | LoggerBase::LOG_LEVEL_ERROR
            | LoggerBase::LOG_LEVEL_WARNING
            | LoggerBase::LOG_LEVEL_MAJOR
            | LoggerBase::LOG_LEVEL_MINOR
            | LoggerBase::LOG_LEVEL_INFO
        );

        if ($config->getValue("debug")) {
            $logger->setLevel(LoggerBase::LOG_LEVEL_DEBUG);
        }

        // Add logging channels
        $logger->addChannel(
            new ConsoleLogChannel()
        );

        return $logger;
    }

    /**
     * Initialize the application facade.
     * @param \FLDSoftware\Config\ConfigBase $config
     * @param \FLDSoftware\Logging\LoggerBase $logger
     * @return \FLDSoftware\Repository\RepositoryBase
     */
    private static function setupFacade(ConfigBase $config, LoggerBase $logger): RepositoryBase {
        $facade = JegyzetRepository::setup($config, $logger);

        return $facade;
    }

    // FIXME
    private static function setupAuthentication(ConfigBase $config, LoggerBase $logger): Authentication {
        return new Authentication();
    }

    /**
     * Initialize the application.
     * @param string $environment Environment name.
     * @return \FLDSoftware\WebApp\WebApplicationBase Web application instance.
     */
    public static function setup(string $environment): WebApplicationBase {
        self::setupRuntime();

        $appData = self::setupAppData($environment);
        $config = self::setupConfig($environment);
        $logger = self::setupLogging($config);

        $facade = self::setupFacade($config, $logger);

        $app = new JegyzetWebApplication(
            $appData,
            $config,
            $facade
        );

        // Set authentication strategies
        $app->setDefaultAuthStrategy(null);

        // Set logger
        $app->setLogger($logger);

        // Perform application setup
        $app->setup();

        return $app;
    }

}
