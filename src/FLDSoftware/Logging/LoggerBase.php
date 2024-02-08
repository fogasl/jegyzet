<?php

namespace FLDSoftware\Logging;

/**
 * Base class for loggers.
 */
class LoggerBase {

    /**
     * No log messages are enabled.
     * @var int
     */
    const LOG_LEVEL_NONE = 0;

    /**
     * Critical log messages: system is unusable.
     * @var int
     */
    const LOG_LEVEL_CRITICAL = 1;

    /**
     * Error log messages: manual intervention required.
     * @var int
     */
    const LOG_LEVEL_ERROR = 2;

    /**
     * Warning log messages: events that are not harmful in themselves, but can
     * lead to errors and, thus, must be checked.
     * @var int
     */
    const LOG_LEVEL_WARNING = 4;

    /**
     * Major error log messages: can be used alternatively instead of Error
     * level. Indicates errors that cannot be automatically recovered from.
     * @var int
     */
    const LOG_LEVEL_MAJOR = 8;

    /**
     * Minor error log messages: can be used alternatively instead of Error
     * level. Indicates errors that can be automatically recovered from but
     * otherwise worth mentioning as unusual behaviour.
     * @var int
     */
    const LOG_LEVEL_MINOR = 16;

    /**
     * Informational log messages: indicates successful operations and
     * intended behaviour.
     * @var int
     */
    const LOG_LEVEL_INFO = 32;

    /**
     * Debug log messages: useful for finding bugs in software. Not recommended
     * in production since this level may leak sensitive data.
     * @var int
     */
    const LOG_LEVEL_DEBUG = 64;

    /**
     * Trace log messages: very low-level messages about program execution,
     * including stack traces. Strictly forbidden in production since it may
     * produce huge log files and affects performance negatively.
     * @var int
     */
    const LOG_LEVEL_TRACE = 128;

    /**
     * Flags of message levels to log. No levels are enabled by default.
     * @var int
     */
    protected int $_level = self::LOG_LEVEL_NONE;

    /**
     * Log message formatter instance.
     * @var \FLDSoftware\Logging\LogFormatterBase
     */
    protected LogFormatterBase $_formatter;

    /**
     * Array of logger channels.
     * @var \FLDSoftware\Logging\ILogChannel[]
     */
    protected array $_channels;

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
        $this->_formatter = new LogFormatterBase();

        // No default channels
        $this->_channels = array();
    }

    /**
     * Enable or disable particular logging levels.
     * @param int $level
     */
    public function setLevel(int $level) {
        $this->_level |= $level;
    }

    /**
     * Sets the message formatter instance.
     * @param \FLDSoftware\Logging\LogFormatterBase $formatter
     */
    public function setFormatter(LogFormatterBase $formatter) {
        $this->_formatter = $formatter;
    }

    /**
     * Add a logging channel to the logger.
     * @param \FLDSoftware\Logging\ILogChannel $channel
     */
    public function addChannel(ILogChannel $channel) {
        $this->_channels[] = $channel;
    }

    /**
     * Remove a particular channel from the logger.
     * @param \FLDSoftware\Logging\ILogChannel $channel
     */
    public function removeChannel(ILogChannel $channel) {
        $this->_channels = array_diff($this->_channels, array($channel));
    }

    /**
     * Generic logging function.
     * @param int $level Log message level.
     * @param string $message Log message. Format strings also supported.
     * @param mixed ...$args Arguments to format the message with.
     */
    public function log(int $level, string $message, ...$args) {
        // Log only if level is enabled
        if ($this->_level & $level) {
            $date = new \DateTimeImmutable();

            $formattedMessage = $this->_formatter->format(
                $level,
                $date,
                $message,
                ...$args
            );

            // broadcast log message to all channels
            foreach ($this->_channels as $channel) {
                $channel->open();
                $channel->write(
                    $date,
                    $level,
                    $formattedMessage
                );
                $channel->close();
            }
        }
    }

}
