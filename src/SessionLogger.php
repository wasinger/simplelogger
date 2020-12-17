<?php

namespace Midweste\SimpleLogger;

use Psr\Log\LogLevel;

class SessionLogger extends AbstractSimpleLogger
{

    public function __construct(LogLevel $min_level = LogLevel::DEBUG, $name = '')
    {
        $this->min_level = $min_level;
        $this->name = (!empty($name) && is_string($name)) ? $name : 'Midweste\SimpleLogger\SessionLogger';
    }

    private function &getSession(): array
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION[$this->name])) {
            $_SESSION[$this->name] = [];
        }
        return $_SESSION[$this->name];
    }

    public function log($level, $message, array $context = array())
    {
        if (!$this->min_level_reached($level)) {
            return;
        }
        $this->getSession()[] = array(
            'timestamp' => date('Y-m-d H:i:s'),
            'level' => $level,
            'message' => $message,
            'context' => $context
        );
    }

    /**
     * Get all log entries
     *
     * @param callable|null $formatter  An optional formatting function called on every log entry.
     *                 This formatting function gets an array parameter with keys 'timestamp', 'level', 'message', and 'context'
     *                 and must return the new log entry.
     * @return array Array of associative log entry arrays with keys 'timestamp', 'level', 'message', and 'context',
     *               unless the log entries are converted to something else by the $formatter parameter.
     */
    public function get($formatter = null)
    {
        $r = $this->getSession();
        if (is_callable($formatter)) {
            foreach ($r as $i => $a) {
                $r[$i] = call_user_func($formatter, $a);
            }
        }
        return $r;
    }

    /**
     * Get all log entries and clear the log
     *
     * @param callable|null $formatter  An optional formatting function called on every log entry.
     *              This formatting function gets an array parameter with keys 'timestamp', 'level', 'message', and 'context'
     *              and must return the new log entry.
     * @return array Array of associative log entry arrays with keys 'timestamp', 'level', 'message', and 'context'
     *               unless the log entries are converted to something else by the $formatter parameter.
     */
    public function getClear($formatter = null)
    {
        $r = $this->getSession();
        $this->clear();
        if (is_callable($formatter)) {
            foreach ($r as $i => $a) {
                $r[$i] = call_user_func($formatter, $a);
            }
        }
        return $r;
    }

    /**
     * Clear the log
     *
     */
    public function clear()
    {
        unset($_SESSION[$this->name]);
    }

    /**
     * Formatter function that can be used as parameter for the get() and getClear() methods
     *
     * @param array $a
     * @return string
     */
    public function formatter(array $a)
    {
        return $this->format($a['level'], $a['message'], $a['context'], $a['timestamp']);
    }
}
