<?php

namespace FLDSoftware\Jegyzet\Repository;

use FLDSoftware\Repository\RepositoryBase;

class UserRepository extends RepositoryBase {

    public function __construct() {
        parent::__construct();
    }

    // Update user profile
    public function updateProfile() {}

    // Add MFA setup to the user profile
    public function setupMfa() {}

    // Remove MFA setup from the user profile
    public function deactivateMfa() {}

    // Change user password
    public function changePassword() {}

    // Delete user's profile (unregister)
    public function deleteProfile() {}

}
