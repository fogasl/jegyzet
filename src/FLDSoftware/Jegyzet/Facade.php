<?php

namespace FLDSoftware\Jegyzet;

use FLDSoftware\Config\ConfigBase;
use FLDSoftware\Facade\FacadeBase;

class Facade extends FacadeBase {

    /**
     * Session subsystem.
     */
    public $session;

    public $notebook;

    public $sheet;

    public $note;

    public $settings;

    public $email;

    public function __construct(ConfigBase $config) {
        parent::__construct($config);
    }

}
