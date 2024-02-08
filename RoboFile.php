<?php

use \Robo\Symfony\ConsoleIO;
use \Robo\Tasks;


/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see https://robo.li/
 */
class RoboFile extends Tasks {

    /**
     * Start development web server.
     * @param int $port Port number to listen on
     */
    public function serve(ConsoleIO $io, int $port = 8080) {
        $this->collectionBuilder($io)->taskServer($port)
            ->dir("www")
            ->run();
    }

    /**
     * Compile assets (css/js/img/etc) and put them into the appropriate
     * directories.
     */
    public function assets(ConsoleIO $io) {
        // Debug
        $this->collectionBuilder($io)->taskConcat(array(
            "vendor/yahoo/purecss/src/base/css/base.css",

            "vendor/yahoo/purecss/src/buttons/css/buttons-core.css",
            "vendor/yahoo/purecss/src/buttons/css/buttons.css",

            "vendor/yahoo/purecss/src/forms/css/forms-r.css",
            "vendor/yahoo/purecss/src/forms/css/forms.css",

            "vendor/yahoo/purecss/src/grids/css/grids-core.css",

            "vendor/yahoo/purecss/src/menus/css/menus-core.css",
            "vendor/yahoo/purecss/src/menus/css/menus-dropdown.css",
            "vendor/yahoo/purecss/src/menus/css/menus-horizontal.css",
            "vendor/yahoo/purecss/src/menus/css/menus-scrollable.css",
            "vendor/yahoo/purecss/src/menus/css/menus-skin.css",

            "vendor/yahoo/purecss/src/tables/css/tables.css"
        ))->to("www/css/pure.css")->run();

        // Release
        $this->collectionBuilder($io)->taskMinify("www/css/pure.css")->to("www/css/pure.min.css")->run();
    }

}
