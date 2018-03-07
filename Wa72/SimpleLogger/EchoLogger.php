<?php
/**
 * This is a logger implementing \Psr\Log\LoggerInterface (PSR-3) that just echos the log messages
 *
 *
 * @author Christoph Singer
 * @license MIT
 */
namespace Wa72\SimpleLogger;
use Psr\Log\LogLevel;

class EchoLogger extends AbstractSimpleLogger
{
    public function __construct($min_level = LogLevel::DEBUG)
    {
        $this->min_level = $min_level;
    }

    public function log($level, $message, array $context = array())
    {
        if (!$this->min_level_reached($level)) {
            return;
        }
        echo $this->format($level, $message, $context);
    }
}
