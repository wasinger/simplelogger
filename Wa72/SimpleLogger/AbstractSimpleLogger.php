<?php
namespace Wa72\SimpleLogger;


use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

abstract class AbstractSimpleLogger extends AbstractLogger
{
    protected $min_level = LogLevel::DEBUG;
    protected $levels = [
        LogLevel::DEBUG,
        LogLevel::INFO,
        LogLevel::NOTICE,
        LogLevel::WARNING,
        LogLevel::ERROR,
        LogLevel::CRITICAL,
        LogLevel::ALERT,
        LogLevel::EMERGENCY
    ];

    /**
     * @param string $level
     * @return boolean
     */
    protected function min_level_reached($level)
    {
        return \array_search($level, $this->levels) >= \array_search($this->min_level, $this->levels);
    }

    /**
     * Interpolates context values into the message placeholders.
     *
     * @author PHP Framework Interoperability Group
     *
     * @param string $message
     * @param array $context
     * @return string
     */
    protected function interpolate($message, array $context)
    {
        if (false === strpos($message, '{')) {
            return $message;
        }

        $replacements = array();
        foreach ($context as $key => $val) {
            if (null === $val || is_scalar($val) || (\is_object($val) && method_exists($val, '__toString'))) {
                $replacements["{{$key}}"] = $val;
            } elseif ($val instanceof \DateTimeInterface) {
                $replacements["{{$key}}"] = $val->format(\DateTime::RFC3339);
            } elseif (\is_object($val)) {
                $replacements["{{$key}}"] = '[object '.\get_class($val).']';
            } else {
                $replacements["{{$key}}"] = '['.\gettype($val).']';
            }
        }

        return strtr($message, $replacements);
    }

    /**
     * @param string $level
     * @param string $message
     * @param array $context
     * @param string|null $timestamp A Timestamp string in format 'Y-m-d H:i:s', defaults to current time
     * @return string
     */
    protected function format($level, $message, $context, $timestamp = null)
    {
        if ($timestamp === null) $timestamp = date('Y-m-d H:i:s');
        return '[' . $timestamp . '] ' . strtoupper($level) . ': ' . $this->interpolate($message, $context) . "\n";
    }
}