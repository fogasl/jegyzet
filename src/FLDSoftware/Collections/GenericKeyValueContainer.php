<?php

namespace FLDSoftware\Collections;

/**
 * Generic container class for key-value based data.
 * Type of the accepted values can be defined.
 * Keys are strings.
 */
class GenericKeyValueContainer {

    /**
     * Type of the values to contain.
     * @var mixed
     */
    protected $_type;

    /**
     * Contains the actual items.
     * @var array
     */
    protected $_items;

    /**
     * Initialize a new instance of the `GenericKeyValueContainer` class.
     * @param $type Type of the contained items
     */
    public function __construct($type = null) {
        $this->_items = array();

        // null type treated as "mixed" to allow arbitrary type
        if ($type === null) {
            $this->_type = mixed;
        } else {
            $this->_type = $type;
        }
    }

    /**
     * Gets the number of items in the collection.
     * @return int
     */
    public function size() {
        return \count($this->_items);
    }

    /**
     * Gets whether the specified key exists in the collection.
     * @param string $key
     * @return bool
     */
    public function hasKey(string $key) {
        return (\array_key_exists($key, $this->_items));
    }

    /**
     * Gets the keys in the collection.
     * @return string[]
     */
    public function getKeys() {
        return \array_keys($this->_items);
    }

    /**
     * Gets the items in the collection as key-value pairs where keys are
     * strings.
     * @return array
     */
    public function getItems() {
        return $this->_items;
    }

    /**
     * Gets a particular item from the collection by its key.
     * @param string $key
     * @return mixed
     * @throws \FLDSoftware\Collections\CollectionException Key not found.
     */
    public function getItem(string $key) {
        if (!(\array_key_exists($key, $this->_items))) {
            throw new CollectionException(
                \sprintf("Key not found: %s", $key)
            );
        }

        return $this->_items[$key];
    }

    /**
     * Try to get a particular item from the collection by its key, and return
     * `null` if key is not found.
     * @param string $key
     * @return mixed
     */
    public function tryGetItem(string $key) {
        try {
            return $this->getItem($key);
        } catch (CollectionException $ex) {
            return null;
        }
    }

    /**
     * Add an item to the collection.
     * Existing keys will be overridden!
     * @param string $key Item key
     * @param mixed $value
     * @return \FLDSoftware\Collections\GenericKeyValueContainer
     * @throws \FLDSoftware\Collections\CollectionException Type mismatch.
     */
    public function setItem(string $key, $value) {
        if (!\is_a($value, $this->_type)) {
            throw new CollectionException(
                \sprintf(
                    "Cannot add type %s (expected: %s)",
                    \gettype($value),
                    $this->_type
                )
            );
        }

        $this->_items[$key] = $value;
        return $this;
    }

    /**
     * Add multiple items to the collection.
     * @param array $items
     * @return \FLDSoftware\Collections\GenericKeyValueContainer
     * @throws \FLDSoftware\Collections\CollectionException Type mismatch.
     */
    public function setItems(array $items) {
        foreach ($items as $key => $val) {
            if (\is_string($key) && \is_a($val, $this->_type)) {
                $this->setItem($key, $val);
            }
        }

        return $this;
    }

    /**
     * Try to add multiple items to the collection, and return `null` if
     * addition fails.
     * @param array $items
     * @return \FLDSoftware\Collections\GenericKeyValueContainer|null
     */
    public function trySetItems(array $items) {
        try {
            $res = $this->setItems($items);
        } catch (CollectionException $err) {
            $res = null;
        }

        return $res;
    }

    /**
     * Remove all items from the collection.
     * @return \FLDSoftware\Collections\GenericKeyValueContainer
     */
    public function removeItems() {
        $this->_items = array();
        return $this;
    }

    /**
     * Remove item from the collection by its key.
     * @param string $key
     * @return \FLDSoftware\Collections\GenericKeyValueContainer
     * @throws \FLDSoftware\Collections\CollectionException Key not found.
     */
    public function removeItem(string $key) {
        if (!(\array_key_exists($key, $this->_items))) {
            throw new CollectionException(
                \sprintf("Key not found: %s", $key)
            );
        }

        unset($this->_items[$key]);
        return $this;
    }

    /**
     * Try to remove item from the collection by its key, and return `null` if
     * removal fails.
     * @param string $key
     * @return \FLDSoftware\Collections\GenericKeyValueContainer|null
     */
    public function tryRemoveItem(string $key) {
        try {
            $res = $this->removeItem($key);
        } catch (CollectionException $ex) {
            $res = null;
        }

        return $res;
    }

}
