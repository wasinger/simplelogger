Wa72SimpleLogger (PHP class)
============================

Wa72SimpleLogger is a collection of very simple logger classes for PHP 5.3 implementing  \Psr\Log\LoggerInterface (PSR-3),
the common logger interface standardized by the PHP Framework Interop Group (www.php-fig.org).

Wa72SimpleLogger is intended for small projects or testing purposes if you don't need a full-featured logging solution
like Monolog.

If you just need to output a few log
messages to a log file but want to stick to the PSR-3 standard (thus having the option to upgrade
to a more advanced logging solution implementing PSR-3) this package is for you.


Loggers
-------

- Wa72Filelogger: Log to a file

- Wa72ArrayLogger: Keep log messages in an array for later use (e.g. display it to the user)

- Wa72ConsoleLogger: Log to the Symfony2 console


Installation
------------

-   using composer: add "wa72/simplelogger": "dev-master" to the "require" section of your composer.json

-   Without composer: just include the logger you need: Wa72FileLogger.php, Wa72ArrayLogger.php or Wa72ConsoleLogger.php


Usage
-----

```php
$logger = new \Wa72FileLogger('/path/to/logfile');
$logger->info('This is the first log message');
```
