<?php

namespace FLDSoftware\Logging;

/**
 * Defines methods for log channel lifecycle handling: opening, closing and
 * writing log messages to the channel.
 */
interface ILogChannel {

    /**
     * Open the logging channel.
     */
    public function open();

    /**
     * Close logging channel.
     */
    public function close();

    /**
     * Write log message to the channel.
     * @param \DateTimeInterface $date Date of the log message
     * @param int $level Log message level (severity)
     * @param string $message Log message text
     */
    public function write(\DateTimeInterface $date, int $level, string $message);

}
