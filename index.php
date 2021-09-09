<?php
require_once("vendor/autoload.php");

$task = new Service\Task("Client", "Worker");
$task->addAction(new Service\CompleteAction());
$task->addAction(new Service\FailAction());
$task->addAction(new Service\AbortAction());
$task->addAction(new Service\ResponseAction());
