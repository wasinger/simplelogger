<?php
/**
 * This class is a very, very simple file logger implementing \Psr\Log\LoggerInterface (PSR-3)
 * 
 * Wa72SimpleLogger is intended for small projects without a framework,
 * or if the used framework does not support PSR-3 yet and you need a PSR-3 compliant logger, and you don't want to use more
 * sophisticated logging solutions like Monolog. If you just need to output a few log
 * messages to a log file but want to stick to the PSR-3 standard (thus having the option to upgrade
 * to another logger) this class is for you.
 * 
 * @author Christoph Singer
 * @license MIT
 */
class Wa72SimpleLogger extends \Psr\Log\AbstractLogger
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
        $logline = '[' . date('Y-m-d h:m:i') . '] ' . strtoupper($level) . ': ' . $this->interpolate($message, $context) . "\n";
        file_put_contents($this->logfile, $logline, FILE_APPEND);
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
