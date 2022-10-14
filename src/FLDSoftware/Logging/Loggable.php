<?php

namespace FLDSoftware\Logging;

/**
 * Base class with logging capabilities.
 */
abstract class Loggable implements ILoggable {

    /**
     * Reference to the logger instance.
     * @var \FLDSoftware\Logging\LoggerBase
     */
    protected $logger;

    /**
     * Low-level logging function.
     * @param int $level Log message level.
     * See {@see \FLDSoftware\Logging\LoggerBase} constants for standard levels
     * @param string $message Log message format string
     * @param $args Additional params for log message format
     * @return \FLDSoftware\Logging\Loggable For method chaining
     */
    public function log(int $level, string $message, ...$args) {
        if ($this->logger !== null) {
            $this->logger->log($level, $message, ...$args);
        }
    }

    /**
     * Log message with "CRITICAL" severity.
     * @param string $message Message to log. Format string is allowed.
     * @param ...$args Arguments to format the message with.
     */
    public function logCritical(string $message, ...$args) {
        $this->log(LoggerBase::LOG_LEVEL_CRITICAL, $message, ...$args);
    }

    /**
     * Log message with "ERROR" severity.
     * @param string $message Message to log. Format string is allowed.
     * @param ...$args Arguments to format the message with.
     */
    public function logError(string $message, ...$args) {
        $this->log(LoggerBase::LOG_LEVEL_ERROR, $message, ...$args);
    }

    /**
     * Log message with "WARNING" severity.
     * @param string $message Message to log. Format string is allowed.
     * @param ...$args Arguments to format the message with.
     */
    public function logWarning(string $message, ...$args) {
        $this->log(LoggerBase::LOG_LEVEL_WARNING, $message, ...$args);
    }

    /**
     * Log message with "MAJOR" severity.
     * @param string $message Message to log. Format string is allowed.
     * @param ...$args Arguments to format the message with.
     */
    public function logMajor(string $message, ...$args) {
        $this->log(LoggerBase::LOG_LEVEL_MAJOR, $message, ...$args);
    }

    /**
     * Log message with "MINOR" severity.
     * @param string $message Message to log. Format string is allowed.
     * @param ...$args Arguments to format the message with.
     */
    public function logMinor(string $message, ...$args) {
        $this->log(LoggerBase::LOG_LEVEL_MINOR, $message, ...$args);
    }

    /**
     * Log message with "DEBUG" severity.
     * @param string $message Message to log. Format string is allowed.
     * @param ...$args Arguments to format the message with.
     */
    public function logDebug(string $message, ...$args) {
        $this->log(LoggerBase::LOG_LEVEL_DEBUG, $message, ...$args);
    }

    /**
     * Log message with "TRACE" severity.
     * @param string $message Message to log. Format string is allowed.
     * @param ...$args Arguments to format the message with.
     */
    public function logTrace(string $message, ...$args) {
        $this->log(LoggerBase::LOG_LEVEL_TRACE, $message, ...$args);
    }

    /**
     * Gets the logger instance.
     * @return \FLDSoftware\Logging\LoggerBase
     */
    public function getLogger() {
        return $this->logger;
    }

    /**
     * Sets the logger instance.
     * @param \FLDSoftware\Logging\LoggerBase $logger Logger instance to set
     */
    public function setLogger(LoggerBase $logger) {
        $this->logger = $logger;
    }

}
