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
$options = getopt('t:m:n:');
$message = $options['m'];
$nbr = $options['n'];

if ($options['t'] == 'error') {
    for ($i = 1; $i <= $nbr; $i++) {    
	$log->error('DevOps ELK Lab : Error', ['Message Body' => $message]);
    }
} else if ($options['t'] == 'warning') {
    for ($i = 1; $i <= $nbr; $i++) {
        $log->warn('DevOps ELK Lab : Warning', ['Message Body' => $message]);
    }
} else if ($options['t'] == 'info') {
    for ($i = 1; $i <= $nbr; $i++) {
        $log->info('DevOps ELK Lab : Info', ['Message Body' => $message]);
    }
}
