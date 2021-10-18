<?php

use taskforce\exceptions\NotValidStatusException;
use taskforce\models\actions\ApproveAction;
use taskforce\models\actions\CompleteAction;
use taskforce\models\Task;

require_once 'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

function dd($data) {
    echo '<pre>' . print_r($data, 1) . '</pre><hr/>';
}

try {
    $not_valid_task = new Task(1, 2, 'abc');
} catch (NotValidStatusException $e) {
    echo $e->getMessage() . '<br/>';
}

try {
    $task = new Task(1, 2, 'in_work');
} catch (NotValidStatusException $e) {
    echo $e->getMessage();
    die();
}

$approveAction = new ApproveAction();
$completeAction = new CompleteAction();

if($task->getNextStatus($completeAction) == Task::STATUS_COMPLETED) {
    echo 'Следующий статус: ' . $task->getNextStatus($completeAction);
}

echo '<hr/>';

echo 'Доступные действия для заказчика (STATUS_NEW):';
dd($task->getAvailableActions(Task::STATUS_NEW, 1));
echo 'Доступные действия для исполнителя (STATUS_NEW):';
dd($task->getAvailableActions(Task::STATUS_NEW, 2));

echo 'Доступные действия для заказчика (STATUS_IN_WORK):';
dd($task->getAvailableActions(Task::STATUS_IN_WORK, 1));
echo 'Доступные действия для исполнителя (STATUS_IN_WORK):';
dd($task->getAvailableActions(Task::STATUS_IN_WORK, 2));

echo 'Доступные действия для исполнителя (STATUS_CANCELED):';
dd($task->getAvailableActions(Task::STATUS_CANCELED, 2));
