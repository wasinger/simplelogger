<?php
use Psr\Log\AbstractLogger;

class Wa72ArrayLogger extends AbstractLogger
{
    protected $memory = array();

    public function log($level, $message, array $context = array())
    {
        $this->memory[] = array(
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
        $r = $this->memory;
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
        $r = $this->memory;
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
        $this->memory = array();
    }
}
