<?php

use TaskForce\logic\Task;

require_once 'vendor/autoload.php';

// настройка assert
assert_options(\ASSERT_ACTIVE, 1);
function assertMessage($file, $line, $code = null, $desc = null)
{
    echo ($desc ? "$desc - " : '') . " line" . $line . "File $file" . \PHP_EOL;
}
assert_options(\ASSERT_CALLBACK, 'assertMessage');

try {
    $task = new Task(1, 23);
    $statusMap = $task->getStatusMap();
    $result = [
        'new' => 'новое задание',
        'canceled' => 'задание отменено',
        'done' => 'задание завершено',
        'failed' => 'задание провалено',
        'work' => 'задание в работе'
    ];
    assert($result === $statusMap, 'Unexpected statuses map');
} catch (AssertionError $e) {
    echo $e->getMessage(), \PHP_EOL;
}
try {
    $task = new Task(1, 23);
    $actionMap = $task->getActionMap();
    $result = [
        'start' => 'стартовать задание',
        'complete' => 'завершить задание',
        'refuse' => 'отказаться от задания',
        'cancel' => 'отменить задание'
    ];
    assert($result === $actionMap, 'Unexpected actions map');
} catch (AssertionError $e) {
    echo $e->getMessage(), \PHP_EOL;
}
try {
    $task = new Task(1, 23);
    $result = $task->mapActionToStatus(Task::ACTION_START);
    $expected = Task::STATUS_WORK;
    assert($result === $expected, 'Unexpected status');
} catch (AssertionError $e) {
    echo $e->getMessage(), \PHP_EOL;
}
try {
    $task = new Task(1, 23);
    $result = $task->mapActionToStatus(Task::ACTION_COMPLETE);
    $expected = Task::STATUS_DONE;
    assert($result === $expected, 'Unexpected status');
} catch (AssertionError $e) {
    echo $e->getMessage(), \PHP_EOL;
}
try {
    $task = new Task(1, 23);
    $result = $task->mapActionToStatus(Task::ACTION_REFUSE);
    $expected = Task::STATUS_FAILED;
    assert($result === $expected, 'Unexpected status');
} catch (AssertionError  $e) {
    echo $e->getMessage(), \PHP_EOL;
}
try {
    $task = new Task(1, 23);
    $result = $task->mapActionToStatus(Task::ACTION_CANCEL);
    $expected = Task::STATUS_CANCELED;
    assert($result === $expected, 'Unexpected status');
} catch (AssertionError  $e) {
    echo $e->getMessage(), \PHP_EOL;
}
try {
    $task = new Task(1, 23);
    $result = $task->mapStatusToAllowedActions(Task::STATUS_NEW);
    $expected = [Task::ACTION_START, Task::ACTION_CANCEL];
    assert($result === $expected, 'Unexpected map of actions');
} catch (AssertionError  $e) {
    echo $e->getMessage(), \PHP_EOL;
}
try {
    $task = new Task(1, 23);
    $result = $task->mapStatusToAllowedActions(Task::STATUS_WORK);
    $expected = [Task::ACTION_COMPLETE, Task::ACTION_REFUSE];
    assert($result === $expected, 'Unexpected map of actions');
} catch (AssertionError  $e) {
    echo $e->getMessage(), \PHP_EOL;
}
try {
    $task = new Task(1, 23);
    $result = $task->mapStatusToAllowedActions(Task::STATUS_CANCELED);
    $expected = [];
    assert($result === $expected, 'Unexpected map of actions');
} catch (AssertionError  $e) {
    echo $e->getMessage(), \PHP_EOL;
}
try {
    $task = new Task(1, 23);
    $result = $task->mapStatusToAllowedActions(Task::STATUS_DONE);
    $expected = [];
    assert($result === $expected, 'Unexpected map of actions');
} catch (AssertionError  $e) {
    echo $e->getMessage(), \PHP_EOL;
}
try {
    $task = new Task(1, 23);
    $result = $task->mapStatusToAllowedActions(Task::STATUS_FAILED);
    $expected = [];
    assert($result === $expected, 'Unexpected map of actions');
} catch (AssertionError  $e) {
    echo $e->getMessage(), \PHP_EOL;
}
