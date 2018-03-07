Wa72SimpleLogger (collection of PHP logger classes)
===================================================

Wa72SimpleLogger is a collection of very simple logger classes for PHP 5.4 implementing  \Psr\Log\LoggerInterface (PSR-3),
the common logger interface standardized by the PHP Framework Interop Group (www.php-fig.org).

Wa72SimpleLogger is intended for small projects or testing purposes if you don't need a full-featured logging solution
like Monolog.

If you just need to output a few log messages in a small PHP project but want to stick to the PSR-3 standard this package is for you. When your project grows you can simply replace it by a more advanced logging solution like Monolog.

Loggers
-------

- \Wa72\SimpleLogger\EchoLogger: Just echo the log message

- \Wa72\SimpleLogger\FileLogger: Log to a file

- \Wa72\SimpleLogger\ArrayLogger: Keep log messages in an array for later use (e.g. display it to the user)

- \Wa72\SimpleLogger\ConsoleLogger: Log to the Symfony2 console => *DEPRECATED: use `Symfony\Component\Console\Logger\ConsoleLogger` instead*


Installation
------------

-   `composer require wa72/simplelogger`


Usage
-----

```php
$logger = new \Wa72\SimpleLogger\FileLogger('/path/to/logfile');
$logger->info('This is the first log message');
```

**NEW**: it's now possible to set a minimum log level in the constructor of FileLogger, EchoLogger and ArrayLogger:

```php
$logger = new \Wa72\SimpleLogger\FileLogger('/path/to/logfile', \Psr\Log\LogLevel::ERROR);
$logger->info('This is the first log message'); // this message will be discarded
$logger->error('This is an error message'); // this message will be logged
```

In one of my projects there was a "fetcher" class that fetched some information from a web service. It needed to log whether this fetch was successfull or not and how many data it fetched. It could be invoked either from the command line, by a background task, or by a user in the admin web page of the application. This was the use case for three logger classes:

- the fetcher class itself just logs to any PSR-3 compliant logger

- if called from a background task (cronjob), it is given a FileLogger

- if called from the command line, it is given a ConsoleLogger

- if called from the web interface, it is given an ArrayLogger. The output of this logger is then displayed to the user on the web page.

