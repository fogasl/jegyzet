<?php

namespace FLDSoftware\Logging;

/**
 * Logging channel that writes log messages to a text file.
 */
class FileLogChannel implements ILogChannel {

    /**
     * Path of the file to log messages to.
     * @var string
     */
    protected string $_filename;

    /**
     * File open mode (rewrite or append depending on the implementation)
     * @var string
     */
    protected string $_mode;

    /**
     * File handle to the log file stream.
     * @var resource
     */
    protected $_handle;

    /**
     * Initializes a new instance of the `FileLogChannel` class.
     * @param string $filename Log file to write
     * @param string $mode File mode (rewrite or append)
     */
    public function __construct(string $filename, string $mode) {
        $this->_filename = $filename;
        $this->_mode = $mode;
    }

    /**
     * Open logging channel.
     */
    public function open() {
        $this->_handle = \fopen($this->_filename, $this->_mode);
    }

    /**
     * Close logging channel.
     */
    public function close() {
        \fclose($this->_handle);
    }

    /**
     * Write log message to the output file.
     * @param \DateTimeInterface $date Date of the log message
     * @param int $level Log message level (severity)
     * @param string $message Log message text
     */
    public function write(\DateTimeInterface $date, int $level, string $message) {
        \fwrite($this->_handle, $message);
    }

}

