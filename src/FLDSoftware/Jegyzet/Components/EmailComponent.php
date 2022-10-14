<?php

namespace FLDSoftware\Jegyzet\Components;

use FLDSoftware\Config\ConfigBase;
use FLDSoftware\Facade\ComponentBase;

class EmailComponent extends ComponentBase {

    public function __construct(ConfigBase $config) {
        parent::__construct($config);
    }

    /**
     * Send email.
     * @param string|string[] $recipients
     * @param string $subject
     * @param string $content
     * @param int $options
     */
    public function send($recipients, $subject, $content, $options) {
        throw new \Exception("Not Implemented");
    }

}
