<?php

namespace FLDSoftware\Jegyzet\DataContract;

interface ISessionQuery {

    // Fetch a single session by ID, return session ID, validity, user
    // Throw on error
    public function fetchById(string $sessionId);

    // Fetch all sessions belonging to a particular user, return session ID, validity, user
    // Throw on error
    public function fetchAllByUser(string $username);

}
