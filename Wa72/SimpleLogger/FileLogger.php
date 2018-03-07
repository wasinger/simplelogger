<?php
/**
 * This class is a simple file logger implementing \Psr\Log\LoggerInterface (PSR-3)
 *
 *
 * @author Christoph Singer
 * @license MIT
 */
namespace Wa72\SimpleLogger;
use Psr\Log\LogLevel;

class FileLogger extends AbstractSimpleLogger
{
    protected $logfile;

    /**
     * @param string $logfile Filename to log messages to (complete path)
     * @param string $min_level
     */
    public function __construct($logfile, $min_level = LogLevel::DEBUG)
    {
        if (!file_exists($logfile)) {
            if (!touch($logfile)) throw new \InvalidArgumentException('Log file ' . $logfile . ' cannot be created');
        }
        if (!is_writable($logfile)) throw new \InvalidArgumentException('Log file ' . $logfile . ' is not writeable');
        $this->logfile = $logfile;
        $this->min_level = $min_level;
    }

    public function log($level, $message, array $context = array())
    {
        if (!$this->min_level_reached($level)) {
            return;
        }
        $logline = $this->format($level, $message, $context);
        file_put_contents($this->logfile, $logline, FILE_APPEND | LOCK_EX);
    }
}
