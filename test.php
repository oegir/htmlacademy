<?php
require_once 'Task.php';

//Новое задание с id заказяика 1 и id исполнителя 23
$task = new TaskForce\Task(1, 23);
$statusMap = $task->getStatusMap();
var_dump($statusMap);
$actionMap = $task->getActionMap();
var_dump($actionMap);
$actionKeys = array_keys($actionMap);
var_dump($actionKeys);
foreach($actionKeys as $key) {
    echo 'for action ', $key, ' status is ', $task->mapActionToStatus($key), \PHP_EOL;
}
$statusKeys = array_keys($statusMap);
foreach($statusKeys as $key) {
    echo 'for status ', $key, ' allowed actions: ';
    var_dump($task->mapStatusToAllowedActions($key));
}
?>
