<?php

namespace FLDSoftware\Config;

/**
 * Base class for parsed configuration files.
 */
class ConfigBase implements \IteratorAggregate {

    /**
     * Array that contains read configuration and default config values
     * merged in a single array.
     * @var array
     */
    protected array $_config = array();

    /**
     * Initialize a new instance of the `ConfigBase` class.
     * @param array $config Config file contents as associative array
     * @param array $defaultConfig Default values as associative array
     */
    public function __construct(array $config = array(), array $defaultConfig = array()) {
        // Merge arrays with overwrite behaviour
        $this->_config = \array_replace_recursive($defaultConfig, $config);
    }

    public function getIterator(): \Traversable {
        return new \ArrayIterator($this->_config);
    }

    /**
     * Gets a config value, or the fallback value if key is not found in the
     * config file.
     * @param string $key Config key to retrieve
     * @return mixed
     * @throws \FLDSoftware\Config\ConfigException
     */
    public function getValue(string $key) {
        $res = null;

        if (\array_key_exists($key, $this->_config)) {
            $res = $this->_config[$key];
        } else {
            throw new ConfigException("Key not found: $key");
        }

        return $res;
    }

}
