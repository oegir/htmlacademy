<?php
require_once 'Task.php';

use TaskForce\Task as Task;

// настройка assert
assert_options(ASSERT_ACTIVE, 1);
function assertMessage($file, $line, $code = null, $desc = null)
{
    echo ($desc ? "$desc - " : '') . " line" . $line . "File $file" . PHP_EOL;
}

assert_options(ASSERT_CALLBACK, 'assertMessage');

try {
    // Status map test
    $task = new Task(1, 23);
    $result = $task->getStatusMap();
    $expected = [
        'new' => 'новое задание',
        'canceled' => 'задание отменено',
        'done' => 'задание завершено',
        'failed' => 'задание провалено',
        'work' => 'задание в работе'
    ];
    assert($result == $expected, 'Unexpected statuses map');
} catch (Error $e) {}

try {
    // Action map test
    $task = new Task(1, 23);
    $result = $task->getActionMap();
    $expected = [
        'start' => 'стартовать задание',
        'complete' => 'завершить задание',
        'refuse' => 'отказаться от задания',
        'cancel' => 'отменить задание'
    ];
    assert($result == $expected, 'Unexpected actions map');
} catch (Error $e) {}

try {
    // mapActionToStatus test
    $task = new Task(1, 23);
    $result = $task->mapActionToStatus(Task::ACTION_START);
    $expected = Task::STATUS_WORK;
    assert($result == $expected, 'Unexpected status');
} catch (Error $e) {}

try {
    // mapActionToStatus test
    $task = new Task(1, 23);
    $result = $task->mapStatusToAllowedActions(Task::STATUS_WORK);
    $expected = [
        Task::ACTION_COMPLETE,
        Task::ACTION_REFUSE
    ];
    assert($result == $expected, 'Unexpected actions set');
} catch (Error $e) {}