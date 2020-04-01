<?php

require __DIR__ . '/vendor/autoload.php';

use Monolog\Logger;

// create a log channel
$log = new Logger('logger');

//Log to stdout
$stdoutHandler = new \Monolog\Handler\ErrorLogHandler();
$formatter = new \Monolog\Formatter\JsonFormatter();
$stdoutHandler->setFormatter($formatter);
$log->pushHandler($stdoutHandler);

// File Handler
$fileHandler = new \Monolog\Handler\RotatingFileHandler('../var/logs/app.log', 0, Logger::DEBUG);
$formatter = new \Monolog\Formatter\JsonFormatter();
$fileHandler->setFormatter($formatter);
$log->pushHandler($fileHandler);

// Elasticsearch Handler
$elasticaClient = new \Elastica\Client(
    [
        'host' => 'localhost',
        'port' => 9200
    ]
);

$elasticsearchHandler = new \Monolog\Handler\ElasticSearchHandler($elasticaClient);
$log->pushHandler($elasticsearchHandler);

// My Application
$options = getopt('a:b:');

# App Server A
if ($options['a'] == 'warning') {
    $log->warn('Ceci est Warning', ['Server' => 'Server A']);
} else {
    $log->info('Ceci est Info', ['Server' => 'Server A']);
}

# App Server B
if ($options['b'] == 'error') {
    $log->error('Ceci est Error', ['Server' => 'Server B']);
} else {
    $log->info('Ceci est Info', ['Server' => 'Server B']);
}



