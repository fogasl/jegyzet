<?php

namespace FLDSoftware\Config;

/**
 * Exception during config file handling and parsing.
 */
class ConfigException extends \Exception {

    public function __construct(string $message, int $code = 0, \Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}
