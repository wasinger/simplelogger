Wa72SimpleLogger (PHP class)
============================

Wa72SimpleLogger is a very, very simple file logger class for PHP 5.3. It implements  \Psr\Log\LoggerInterface (PSR-3), 
the common logger interface standardized by the PHP Framework Interop Group (www.php-fig.org).

Wa72SimpleLogger is intended for small projects without a framework,
or if your framework does not support PSR-3 yet but a library you use requires it, and you don't want to use more
sophisticated logging solutions like Monolog. 

If you just need to output a few log
messages to a log file but want to stick to the PSR-3 standard (thus having the option to upgrade
to another logger) this class is for you.

Installation
------------

-   using composer: add "wa72/simplelogger": "dev-master" to the "require" section of your composer.json

-   Without composer: just include Wa72SimpleLogger.php 

Usage
-----

```php
$logger = new \Wa72SimpleLogger('/path/to/logfile');
$logger->info('This is the first log message');
```
