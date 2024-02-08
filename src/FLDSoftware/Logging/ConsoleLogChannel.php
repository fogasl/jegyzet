<?php

namespace FLDSoftware\Logging;

/**
 * Logging channel that writes log messages to the standard output
 * (e.g. the terminal console, hence the name)
 * FIXME: FileLogChannel should be the base class! filename:php://stdout
 */
class ConsoleLogChannel implements ILogChannel {

    /**
     * File handle to the standard output stream.
     * @var resource
     */
    protected $_handle;

    /**
     * Initialize a new instance of the `ConsoleLogChannel` class.
     */
    public function __construct() {
    }

    /**
     * Open logging channel.
     */
    public function open() {
        $this->_handle = \fopen("php://stdout", "w");
    }

    /**
     * Close logging channel.
     */
    public function close() {
        \fclose($this->_handle);
    }

    /**
     * Write log message to the standard output.
     * @param \DateTimeInterface $date Date of the log message
     * @param int $level Log message level (severity)
     * @param string $message Log message text
     */
    public function write(\DateTimeInterface $date, int $level, string $message) {
        \fwrite($this->_handle, $message);
    }

}
