<?php
/**
 * This class is a simple file logger implementing \Psr\Log\LoggerInterface (PSR-3)
 *
 *
 * @author Christoph Singer
 * @license MIT
 */
namespace Wa72\SimpleLogger;
class FileLogger extends \Psr\Log\AbstractLogger
{
    protected $logfile;

    /**
     * @param string $logfile Filename to log messages to (complete path)
     * @throws \InvalidArgumentException When logfile cannot be created or is not writeable
     */
    public function __construct($logfile)
    {
        if (!file_exists($logfile)) {
            if (!touch($logfile)) throw new \InvalidArgumentException('Log file ' . $logfile . ' cannot be created');
        }
        if (!is_writable($logfile)) throw new \InvalidArgumentException('Log file ' . $logfile . ' is not writeable');
        $this->logfile = $logfile;
    }

    public function log($level, $message, array $context = array())
    {
        $logline = '[' . date('Y-m-d H:i:s') . '] ' . strtoupper($level) . ': ' . $this->interpolate($message, $context) . "\n";
        file_put_contents($this->logfile, $logline, FILE_APPEND | LOCK_EX);
    }

    /**
     * Interpolates context values into the message placeholders.
     *
     * This function is just copied from the example in the PSR-3 spec
     *
     */
    protected function interpolate($message, array $context = array())
    {
        // build a replacement array with braces around the context keys
        $replace = array();
        foreach ($context as $key => $val) {
            $replace['{' . $key . '}'] = $val;
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }
}
