<?php

namespace FLDSoftware\Logging;

/**
 * Base class for loggers.
 */
class LoggerBase {

    /**
     * Level of critical log messages.
     * @var int
     */
    const LOG_LEVEL_CRITICAL = 1;

    const LOG_LEVEL_ERROR = 2;

    const LOG_LEVEL_WARNING = 4;

    const LOG_LEVEL_MAJOR = 8;

    const LOG_LEVEL_MINOR = 16;

    const LOG_LEVEL_DEBUG = 32;

    const LOG_LEVEL_TRACE = 64;

    /**
     * Flags of message levels to log.
     * @var int
     */
    protected $level;

    /**
     * Log message formatter instance.
     * @var \FLDSoftware\Logging\LogFormatterBase
     */
    protected $formatter;

    /**
     * Array of logger channels.
     * @var \FLDSoftware\Logging\LogChannelBase[]
     */
    protected $channels;

    /**
     * Initialize a new instance of the `LoggerBase` class with default
     * levels, formatter, and logging channels.
     */
    public function __construct() {
        // Default levels
        $this->setLevel(
            self::LOG_LEVEL_CRITICAL
            | self::LOG_LEVEL_ERROR
            | self::LOG_LEVEL_WARNING
        );

        // Set default log message formatter
        $this->formatter = new LogFormatterBase();

        // No default channels
        $this->channels = array();
    }

    /**
     * Enable or disable particular logging levels.
     * @param int $level
     */
    public function setLevel(int $level) {
        $this->level |= $level;
    }

    /**
     * Sets the message formatter instance.
     * @param \FLDSoftware\Logging\LogFormatterBase $formatter
     */
    public function setFormatter(LogFormatterBase $formatter) {
        $this->formatter = $formatter;
    }

    /**
     * Add a logging channel to the logger.
     * @param \FLDSoftware\Logging\LogChannelBase $channel
     */
    public function addChannel(LogChannelBase $channel) {
        $this->channels[] = $channel;
    }

    /**
     * Remove a particular channel from the logger.
     * @param \FLDSoftware\Logging\LogChannelBase $channel
     */
    public function removeChannel(LogChannelBase $channel) {
        unset($this->channels[$channel]);
    }

    /**
     * Generic logging function.
     * @param int $level Log message level.
     * @param string $message Log message. Format strings also supported.
     * @param mixed ...$args Arguments to format the message with.
     */
    public function log(int $level, string $message, ...$args) {
        // Log only if level is enabled
        if ($this->level & $level) {
            $date = new \DateTime();

            $formattedMessage = $this->formatter->format(
                $level,
                $date,
                $message,
                ...$args
            );

            // broadcast log message to all channels
            foreach ($this->channels as $channel) {
                $channel->open();
                $channel->write(
                    new \DateTime(),
                    $level,
                    $formattedMessage
                );
                $channel->close();
            }
        }
    }

}
