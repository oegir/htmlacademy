<?php
require_once("vendor/autoload.php");
$task = new Service\Task("Client", "Worker");
$task->addAction(new Service\CompleteAction("actComplete", "Выполнить"));
$task->addAction(new Service\FailAction("actFail", "Отказаться"));
$task->addAction(new Service\AbortAction("actAbort", "Отменить задание"));
$task->addAction(new Service\ResponseAction("actResponse", "Откликнуться"));
