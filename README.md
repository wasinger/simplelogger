Wa72SimpleLogger (PHP class)
============================

Wa72SimpleLogger is a very, very simple file logger class for PHP 5.3 implementing \Psr\Log\LoggerInterface (PSR-3)

Wa72SimpleLogger is intended for small projects without a framework,
or if your framework does not support PSR-3 yet, and you don't want to use more
sophisticated logging solutions like Monolog. 

If you just need to output a few log
messages to a log file but want to stick to the PSR-3 standard (thus having the option to upgrade
to another logger) this class is for you.
