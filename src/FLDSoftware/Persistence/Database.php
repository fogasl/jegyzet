<?php

namespace FLDSoftware\Persistence;

use FLDSoftware\Logging\Loggable;

/**
 * Handles relational database connection, wrap query language to map DB
 * entities to model classes.
 */
class Database extends Loggable {

    protected \PDO $pdo;

    public function __construct(string $dsn, string $username = null, string $password = null) {
        $this->pdo = new \PDO($dsn, $username, $password);
    }

    // public function getEntities(string $cls, array $criteria) {
    // }

    // public function getEntity(string $cls) {
    // }

    // public function addEntities(array $entities) {}

    // public function addEntity(Entity $entity) {
    //     $tbl = $entity->tableName();
    // }

    // public function updateEntity(Entity $entity) {}

    // public function addOrUpdateEntity(Entity $entity) {}

    // public function removeEntities(array $entities) {}

    // public function removeEntity(Entity $entity) {}

    // Execute stored procedure
    public function execute(string $name, array $args = array()): DbResult {
        throw new \Exception("Not Implemented");
    }

}
