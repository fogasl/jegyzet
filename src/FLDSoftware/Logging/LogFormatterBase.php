<?php

namespace FLDSoftware\Logging;

/**
 * Base class for log message formatters.
 */
class LogFormatterBase {

    /**
     * The default log message format string.
     * @var string
     */
    const DEFAULT_FORMAT = "%s [%s]\t%s%s";

    /**
     * The default date format string.
     * @var string
     */
    const DEFAULT_DATE_FORMAT = "Y-m-d H:i:s.u";

    /**
     * The adjusted log message format string.
     * @var string
     */
    protected string $_formatString;

    /**
     * The adjusted date format string.
     * @var string
     */
    protected string $_dateFormatString;

    /**
     * Get log message level name.
     * @param int $level {@see \FLDSoftware\Logging\LoggerBase} constants.
     * @return string
     */
    public static function getLevelName(int $level) {
        $res = "";

        if ($level & LoggerBase::LOG_LEVEL_CRITICAL) {
            $res = "CRITICAL";
        }
        elseif ($level & LoggerBase::LOG_LEVEL_ERROR) {
            $res = "ERROR";
        }
        elseif ($level & LoggerBase::LOG_LEVEL_WARNING) {
            $res = "WARNING";
        }
        elseif ($level & LoggerBase::LOG_LEVEL_MAJOR) {
            $res = "MAJOR";
        }
        elseif ($level & LoggerBase::LOG_LEVEL_MINOR) {
            $res = "MINOR";
        }
        elseif ($level & LoggerBase::LOG_LEVEL_INFO) {
            $res = "INFO";
        }
        elseif ($level & LoggerBase::LOG_LEVEL_DEBUG) {
            $res = "DEBUG";
        }
        elseif ($level & LoggerBase::LOG_LEVEL_TRACE) {
            $res = "TRACE";
        } else {
            $res = "???";
        }

        return $res;
    }

    /**
     * Initialize a new instance of the `LogFormatterBass` class with
     * custom format string.
     * @param string $formatString Log message format string.
     * @param string $dateFormatString Date format string.
     */
    public function __construct(string $formatString = self::DEFAULT_FORMAT, string $dateFormatString = self::DEFAULT_DATE_FORMAT) {
        $this->_formatString = $formatString;
        $this->_dateFormatString = $dateFormatString;
    }

    /**
     * Format the log message.
     * @param int $level Level (severity) of the log message
     * @param \DateTimeInterface $date Date of the log message
     * @param string $message Log message
     * @param mixed ...$args Arguments to format the message with
     * @return string Formatted log message.
     */
    public function format(int $level, \DateTimeInterface $date, string $message, ...$args) {
        return \sprintf(
            $this->_formatString,
            $date->format($this->_dateFormatString),
            self::getLevelName($level),
            \sprintf(
                $message,
                ...$args
            ),
            \PHP_EOL
        );
    }

}
