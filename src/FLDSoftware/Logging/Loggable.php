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
    protected LoggerBase $_logger;

    /**
     * Low-level logging function.
     * @param int $level Log message level.
     * See {@see \FLDSoftware\Logging\LoggerBase} constants for standard levels
     * @param string $message Log message format string
     * @param $args Additional params for log message format
     * @return \FLDSoftware\Logging\Loggable For method chaining
     */
    public function log(int $level, string $message, ...$args) {
        if ($this->_logger !== null) {
            $this->_logger->log($level, $message, ...$args);
        }

        return $this;
    }

    /**
     * Log message with "CRITICAL" severity.
     * @param string $message Message to log. Format string is allowed.
     * @param ...$args Arguments to format the message with.
     * @return \FLDSoftware\Logging\Loggable For method chaining
     */
    public function logCritical(string $message, ...$args) {
        return $this->log(LoggerBase::LOG_LEVEL_CRITICAL, $message, ...$args);
    }

    /**
     * Log message with "ERROR" severity.
     * @param string $message Message to log. Format string is allowed.
     * @param ...$args Arguments to format the message with.
     * @return \FLDSoftware\Logging\Loggable For method chaining
     */
    public function logError(string $message, ...$args) {
        return $this->log(LoggerBase::LOG_LEVEL_ERROR, $message, ...$args);
    }

    /**
     * Log message with "WARNING" severity.
     * @param string $message Message to log. Format string is allowed.
     * @param ...$args Arguments to format the message with.
     * @return \FLDSoftware\Logging\Loggable For method chaining
     */
    public function logWarning(string $message, ...$args) {
        return $this->log(LoggerBase::LOG_LEVEL_WARNING, $message, ...$args);
    }

    /**
     * Log message with "MAJOR" severity.
     * @param string $message Message to log. Format string is allowed.
     * @param ...$args Arguments to format the message with.
     * @return \FLDSoftware\Logging\Loggable For method chaining
     */
    public function logMajor(string $message, ...$args) {
        return $this->log(LoggerBase::LOG_LEVEL_MAJOR, $message, ...$args);
    }

    /**
     * Log message with "MINOR" severity.
     * @param string $message Message to log. Format string is allowed.
     * @param ...$args Arguments to format the message with.
     * @return \FLDSoftware\Logging\Loggable For method chaining
     */
    public function logMinor(string $message, ...$args) {
        return $this->log(LoggerBase::LOG_LEVEL_MINOR, $message, ...$args);
    }

    /**
     * Log message with "INFO" severity.
     * @param string $message Message to log. Format string is allowed.
     * @param ...$args Arguments to format the message with.
     * @return \FLDSoftware\Logging\Loggable For method chaining
     */
    public function logInfo(string $message, ...$args) {
        return $this->log(LoggerBase::LOG_LEVEL_INFO, $message, ...$args);
    }

    /**
     * Log message with "DEBUG" severity.
     * @param string $message Message to log. Format string is allowed.
     * @param ...$args Arguments to format the message with.
     * @return \FLDSoftware\Logging\Loggable For method chaining
     */
    public function logDebug(string $message, ...$args) {
        return $this->log(LoggerBase::LOG_LEVEL_DEBUG, $message, ...$args);
    }

    /**
     * Log message with "TRACE" severity.
     * @param string $message Message to log. Format string is allowed.
     * @param ...$args Arguments to format the message with.
     * @return \FLDSoftware\Logging\Loggable For method chaining
     */
    public function logTrace(string $message, ...$args) {
        return $this->log(LoggerBase::LOG_LEVEL_TRACE, $message, ...$args);
    }

    /**
     * Gets the logger instance.
     * @return \FLDSoftware\Logging\LoggerBase
     */
    public function getLogger() {
        return $this->_logger;
    }

    /**
     * Sets the logger instance.
     * @param \FLDSoftware\Logging\LoggerBase $logger Logger instance to set
     */
    public function setLogger(LoggerBase $logger) {
        $this->_logger = $logger;
    }

}
