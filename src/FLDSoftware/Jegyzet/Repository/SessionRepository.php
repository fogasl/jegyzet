<?php

namespace FLDSoftware\Jegyzet\Repository;

use FLDSoftware\Jegyzet\DataContract\SessionQuery;
use FLDSoftware\Repository\RepositoryBase;

class SessionRepository extends RepositoryBase {

    public function __construct() {
        parent::__construct();
    }

    // Check whether a particular session is valid or not.
    // Return session data (id, validity, user)
    public function check(string $sessionId) {
        try {
            $query = new SessionQuery(null);
            $query->fetchById($sessionId);
        } catch (\Exception $ex) {
            $this->logError($ex->getMessage());
        }
    }

    // Extend a particular sessions' validity.
    // Addition parameter should come from environment variable.
    // Return session data (id, validity, user)
    public function extend() {}

    // Terminate a particular session (remove from db)
    // return true on success, false on failure
    public function terminate() {}

    // Sign in for existing users
    public function signIn(string $username, string $password) {}

    // Sign in for existing users with Multi-Factor Authentication
    public function signInMfa(string $username, string $password, string $otp) {}

    public function signOut(string $sessionId) {}

    public function recoverPassword(string $email) {}

    // Register new user account
    public function signUp() {}

    // Confirm registration
    public function confirm() {}

}
