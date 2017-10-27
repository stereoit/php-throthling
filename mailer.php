<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Eventival/EmailQueue.php';

// $queue = new Eventival\EmailQueue;
// $queue = Eventival\EmailQueueFactory::create();
$queue = new Eventival\EmailQueue;

$identifier = $argc < 2 ? 'single' : $argv[1];

while(true) {
    $msg = $queue->nextEmail($identifier);
    sleep(1);
    echo $msg;
}