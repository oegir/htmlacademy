<?php

use taskforce\actions\ApproveAction;
use taskforce\Task;

require_once 'vendor/autoload.php';

function dd($data) {
    echo '<pre>' . print_r($data, 1) . '</pre><hr/>';
}

$task = new Task(1, 2);

$approveAction = new ApproveAction();

if($task->getNextStatus($approveAction) == Task::STATUS_IN_WORK) {
    echo 'Следующий статус: ' . $task->getNextStatus($approveAction);
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