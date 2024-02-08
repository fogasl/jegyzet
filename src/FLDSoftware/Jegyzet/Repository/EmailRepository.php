<?php

namespace FLDSoftware\Jegyzet\Repository;

use FLDSoftware\Repository\RepositoryBase;

class EmailRepository extends RepositoryBase {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Send email.
     * @param string|string[] $recipients
     * @param string $subject
     * @param string $content
     * @param int $options
     */
    public function send(string|array $recipients, string $subject, string $content, int $options) {
        throw new \Exception("Not Implemented");
    }

}
