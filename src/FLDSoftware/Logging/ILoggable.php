<?php

namespace FLDSoftware\Logging;

/**
 * Defines method for logging.
 */
interface ILoggable {

    /**
     * Low-level logger function.
     * @param int $level Log message level (severity)
     * @param string $message Log message. Format string also supported.
     * @param mixed ...$args Arguments to format the message with.
     */
    public function log(int $level, string $message, ...$args);

}
