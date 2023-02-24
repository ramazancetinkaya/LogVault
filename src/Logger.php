<?php

/**
 * Logger Class
 * 
 * A PSR-3 compliant logger that supports advanced features such as log levels, context, and custom handlers.
 *
 * @package    Logger
 * @category   Logging
 * @author     Ramazan Çetinkaya
 * @license    MIT License
 * @version    1.0
 * @link       https://github.com/ramazancetinkaya/LogVault
 */
class Logger implements Psr\Log\LoggerInterface
{
    /** @var array Maps PSR-3 log levels to their corresponding syslog priorities */
    private const LEVEL_MAP = [
        'emergency' => LOG_EMERG,
        'alert'     => LOG_ALERT,
        'critical'  => LOG_CRIT,
        'error'     => LOG_ERR,
        'warning'   => LOG_WARNING,
        'notice'    => LOG_NOTICE,
        'info'      => LOG_INFO,
        'debug'     => LOG_DEBUG,
    ];

    /** @var callable[] An array of callbacks to be invoked for each log entry */
    private $handlers = [];

    /** @var string The minimum log level that will be logged */
    private $level = 'debug';

    /**
     * Creates a new instance of the logger.
     *
     * @param string $level The minimum log level that will be logged
     */
    public function __construct(string $level = 'debug')
    {
        $this->setLogLevel($level);
    }

    /**
     * Adds a handler to be called for each log entry.
     *
     * @param callable $handler The handler to add
     */
    public function addHandler(callable $handler): void
    {
        $this->handlers[] = $handler;
    }

    /**
     * Sets the minimum log level that will be logged.
     *
     * @param string $level The minimum log level that will be logged
     */
    public function setLogLevel(string $level): void
    {
        $this->level = $level;
    }

    /**
     * Logs a message at the specified level.
     *
     * @param string $level   The log level (e.g. "error", "warning", "info")
     * @param string $message The log message
     * @param array  $context Optional context information to include in the log message
     */
    public function log($level, $message, array $context = []): void
    {
        if (!isset(self::LEVEL_MAP[$level])) {
            throw new InvalidArgumentException(sprintf('Invalid log level "%s"', $level));
        }

        if (array_search($level, array_keys(self::LEVEL_MAP)) > array_search($this->level, array_keys(self::LEVEL_MAP))) {
            return; // This log level is below the configured minimum, so do nothing
        }

        $logData = [
            'timestamp' => time(),
            'level'     => $level,
            'message'   => $message,
            'context'   => $context,
        ];

        foreach ($this->handlers as $handler) {
            $handler($logData);
        }
    }
}
