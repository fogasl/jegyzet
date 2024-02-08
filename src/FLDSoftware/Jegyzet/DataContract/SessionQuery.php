<?php

namespace FLDSoftware\Jegyzet\DataContract;

use FLDSoftware\Persistence\Database;

class SessionQuery implements ISessionQuery {

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function fetchById(string $sessionId) {
        throw new \Exception("Not Implemented");
    }

    public function fetchAllByUser(string $username) {
        throw new \Exception("Not Implemented");
    }

}
