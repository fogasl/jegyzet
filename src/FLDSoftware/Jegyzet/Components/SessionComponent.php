<?php

namespace FLDSoftware\Jegyzet\Components;

use FLDSoftware\Config\ConfigBase;
use FLDSoftware\Facade\ComponentBase;
use FLDSoftware\Jegyzet\Models\SessionModel;

class SessionComponent extends ComponentBase {

    public function __construct(ConfigBase $config) {
        parent::__construct($config);
    }

    public function getSigninModel() {
        return new SessionModel();
    }

    public function signin($username, $password) {
        // Create password hash
        // Check username and hash match in the db
        //throw new \Exception("Not Implemented");

        return array(
            "sessionId" => "..."
        );
    }

    public function signout($sessionId) {
        throw new \Exception("Not Implemented");
    }

    public function register($username) {
        // Register session for user
        throw new \Exception("Not Implemented");
    }

    public function resetPassword($username) {
        throw new \Exception("Not Implemented");
    }

}
