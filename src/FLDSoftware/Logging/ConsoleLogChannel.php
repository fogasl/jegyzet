<?php

namespace FLDSoftware\Logging;

/**
 * Logging channel that writes log messages to the standard output
 * (e.g. the terminal console, hence the name)
 */
class ConsoleLogChannel extends LogChannelBase {

    /**
     * File handle to the standard output stream.
     * @var resource
     */
    protected $handle;

    /**
     * Initialize a new instance of the `ConsoleLogChannel` class.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Open logging channel.
     */
    public function open() {
        $this->handle = \fopen("php://stdout", "w");
    }

    /**
     * Close logging channel.
     */
    public function close() {
        \fclose($this->handle);
    }

    /**
     * Write log message to the standard output.
     * @param \DateTime $date Date of the log message
     * @param int $level Log message level (severity)
     * @param string $message Log message text
     */
    public function write(\DateTime $date, int $level, string $message) {
        \fwrite($this->handle, $message);
    }

}
