<?php

namespace FLDSoftware\Jegyzet\Controllers;

use FLDSoftware\Pathlib\Path;
use FLDSoftware\WebApp\Controllers\ControllerBase;
use FLDSoftware\WebApp\WebApplicationBase;

/**
 * Base class for all controllers in the **Jegyzet** web application.
 */
abstract class JegyzetControllerBase extends ControllerBase {

    /**
     * Initializes a new instance of the `JegyzetControllerBase` class.
     * @param \FLDSoftware\WebApp\WebApplicationBase $context Application context
     */
    public function __construct(WebApplicationBase $context = null) {
        parent::__construct($context);
    }

    /**
     * Gets the template root directory path.
     * @return \FLDSoftware\Pathlib\Path
     */
    protected function getTemplatesDir() {
        return new Path(
            __DIR__,
            "..",
            "Templates"
        );
    }

    /**
     * Return file path for a specific view.
     * @param string $component Component name (subdirectory name in the Views
     * directory)
     * @param string $file View file name
     * @return \FLDSoftware\Pathlib\Path Path of the view file
     */
    protected function getView(string $component, string $file) {
        return new Path(
            $this->getTemplatesDir(),
            $component,
            $file
        );
    }

}
