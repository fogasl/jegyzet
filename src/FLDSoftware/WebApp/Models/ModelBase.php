<?php

namespace FLDSoftware\WebApp\Models;

/**
 * Base class for **Models**.
 *
 * A model represents an **entity** with its properties and persistence.
 */
class ModelBase {

    protected $tableName;

    /**
     * Initialize the model.
     */
    public function __construct($dbConfig, $tableName) {}

    /**
     * Return all instances of the given entity.
     * @return  ModelBase[]     All entities.
     */
    public function getAll() {}

    /**
     * Fetch a single entity by its identifier.
     * @param   int $id     Identifier of the entity to get.
     * @return  ModelBase   Model instance.
     * @throws  \Exception   No entity was found with the given identifier.
     */
    public function getById($id) {}

    static function retrieveById($id) {
        try {
            $entity = new self();
            $tbl = $entity->getTableName();
        } catch (\Throwable $t) {

        }
    }

    /**
     * Fetch all entities matching the given criteria.
     * @param   array<string, string>   $criteria   Fetch criteria.
     * @param   int $limit  How many entities to fetch. Defaults to fetch all matching.
     * @return  ModelBase[] All matching entities.
     * @throws  \Exception  Invalid criteria.
     */
    public function getByCriteria($criteria = array(), $limit = -1) {}

    /**
     * Add an entity to the persistent storage.
     */
    public function add() {}

    /**
     * Add an entity to the persistent storage or update its properties if exists.
     */
    public function addOrUpdate() {}

    /**
     * Update all entities.
     */
    public function updateAll() {}

    public function updateById($id) {}

    public function updateByCriteria($criteria = array()) {}

    /**
     * Remove all entities from the persistent storage.
     */
    public function remove() {}

    /**
     * Remove a single entity by its identifier.
     * @param   int     $id     Entity identifier.
     */
    public function removeById($id) {}

    /**
     * Remove all entities  matching the given criteria.
     * @param   array<string, string>   $criteria   Delete criteria.
     * @return
     */
    public function removeByCriteria($criteria = array()) {}

    /**
     * Returns a string that represents the current model object.
     * @return string String representation of the model.
     */
    public function __toString() {
        // FIXME: return a value!
        return "";
    }

}
