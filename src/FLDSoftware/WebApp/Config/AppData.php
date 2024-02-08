<?php

namespace FLDSoftware\WebApp\Config;

use FLDSoftware\Pathlib;

/**
 * Container for application manifest data such as application name,
 * version, and others.
 */
class AppData {

    /**
     * Name of the default project descriptor file.
     * @var string
     */
    const DEFAULT_COMPOSER_FILE_NAME = "composer.json";

    /**
     * Application name.
     * @var string
     */
    public $name;

    /**
     * Application description.
     * @var string
     */
    public $description;

    /**
     * Application version.
     * @var string
     */
    public $version;

    /**
     * Name of the main author of the application.
     * @var string
     */
    public $author;

    /**
     * Name of the environment in which the application runs.
     * (one of the following: `production`, `development`, `test`, `unittest`)
     * @var string
     */
    public $environment;

    /**
     * Load project descriptor file from the given location, parse its
     * contents, and return an `AppData` class instance populated with the
     * aforementioned data.
     * @param string $baseDir Project root directory path
     * @param string $fileName Project descriptor file name
     * @return \FLDSoftware\WebApp\Config\AppData
     */
    public static function fromComposerFile(string $baseDir, string $fileName = self::DEFAULT_COMPOSER_FILE_NAME) {
        $res = new self();

        $path = new Pathlib\Path($baseDir, $fileName);

        if (!($path->exists())) {
            throw new Pathlib\PathException(
                \sprintf(
                    "Cannot open %s: file does not exist",
                    $path
                )
            );
        }

        $fileText = \file_get_contents($path);
        $fileJson = \json_decode($fileText, true);

        list($namespace, $appName) = explode("/", $fileJson["name"], 2);

        $res->name = $appName;
        $res->description = $fileJson["description"];
        $res->version = $fileJson["version"];

        $authors = $fileJson["authors"];

        // First of the authors is the main author
        $res->author = $authors[0]["name"];

        return $res;
    }

}
