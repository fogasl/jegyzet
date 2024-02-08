<?php

namespace FLDSoftware\Jegyzet\Repository;

use FLDSoftware\Config\ConfigBase;
use FLDSoftware\Logging\LoggerBase;
use FLDSoftware\Repository\RepositoryBase;

class JegyzetRepository extends RepositoryBase {

    public AdminRepository $admin;

    public EmailRepository $email;

    public NotebookRepository $notebook;

    public NoteRepository $note;

    public SessionRepository $session;

    public SettingsRepository $settings;

    public UserRepository $user;

    public function __construct() {
        parent::__construct();
    }

    public static function setup(ConfigBase $config, LoggerBase $logger = null): self {
        $res = new self();
        $res->setLogger($logger);

        // Repositories to register
        $repositories = array(
            AdminRepository::class,
            EmailRepository::class,
            NotebookRepository::class,
            NoteRepository::class,
            SessionRepository::class,
            SettingsRepository::class,
            UserRepository::class
        );

        // Register every repository and set logger instance
        foreach ($repositories as $repo) {
            $res->register($repo);
            $r = self::getRepositoryName($repo);
            $res->$r->setLogger($logger);
        }

        return $res;
    }

}
