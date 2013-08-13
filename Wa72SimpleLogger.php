<?php
require (__DIR__ . '/Wa72/SimpleLogger/FileLogger.php');
/**
 * This class is a very, very simple file logger implementing \Psr\Log\LoggerInterface (PSR-3).
 * It is now called \Wa72\SimpleLogger\FileLogger and the deprecated class Wa72SimpleLogger is kept only for compatibility.
 * 
 * @author Christoph Singer
 * @license MIT
 * @deprecated
 * @see Wa72\SimpleLogger\FileLogger
 */
class Wa72SimpleLogger extends \Wa72\SimpleLogger\FileLogger
{
}
