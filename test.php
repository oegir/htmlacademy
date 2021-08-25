<?php

use TaskForce\logic\Task;

require_once 'vendor/autoload.php';

/**
 * Проверка ожидаемого результата
 *
 * @param mixed  $result   некоторое значение переменной
 * @param mixed  $expected ожидаемое значение переменной
 * @param string $msg      сообщение в случае несовпадения значений
 */
function assertTest($result, $expected, $msg)
{
    try {
        assert($result === $expected, $msg);
    } catch (Error $e) {
        echo $e->getMessage(), \PHP_EOL;
    }
}

// настройка assert
assert_options(\ASSERT_ACTIVE, 1);
function assertMessage($file, $line, $code = null, $desc = null)
{
    echo ($desc ? "$desc - " : '') . " line" . $line . "File $file" . \PHP_EOL;
}
assert_options(\ASSERT_CALLBACK, 'assertMessage');

$task = new Task(1, 23);
$statusMap = $task->getStatusMap();
$result = [
    'new' => 'новое задание',
    'canceled' => 'задание отменено',
    'done' => 'задание завершено',
    'failed' => 'задание провалено',
    'work' => 'задание в работе'
];
assertTest($result, $statusMap, 'Unexpected statuses map 1');

$actionMap = $task->getActionMap();
$result = [
    'start' => 'стартовать задание',
    'complete' => 'завершить задание',
    'refuse' => 'отказаться от задания',
    'cancel' => 'отменить задание'
];
assertTest($result, $actionMap, 'Unexpected actions map 2');

$result = $task->mapActionToStatus(Task::ACTION_START);
$expected = Task::STATUS_WORK;
assertTest($result, $expected, 'Unexpected status for action ' . Task::ACTION_START);

$result = $task->mapActionToStatus(Task::ACTION_COMPLETE);
$expected = Task::STATUS_DONE;
assertTest($result, $expected, 'Unexpected status for action ' . Task::ACTION_COMPLETE);

$result = $task->mapActionToStatus(Task::ACTION_REFUSE);
$expected = Task::STATUS_FAILED;
assertTest($result, $expected, 'Unexpected status for action ' . Task::ACTION_REFUSE);

$result = $task->mapActionToStatus(Task::ACTION_CANCEL);
$expected = Task::STATUS_CANCELED;
assertTest($result, $expected, 'Unexpected status for action ' . Task::ACTION_CANCEL);

$result = $task->mapStatusToAllowedActions(Task::STATUS_NEW);
$expected = [Task::ACTION_START, Task::ACTION_CANCEL];
assertTest($result, $expected, 'Unexpected map of actions for status ' . Task::STATUS_NEW);

$result = $task->mapStatusToAllowedActions(Task::STATUS_WORK);
$expected = [Task::ACTION_COMPLETE, Task::ACTION_REFUSE];
assertTest($result, $expected, 'Unexpected map of actions for status ' . Task::STATUS_WORK);

$result = $task->mapStatusToAllowedActions(Task::STATUS_CANCELED);
$expected = [];
assertTest($result, $expected, 'Unexpected map of actions for status ' . Task::STATUS_CANCELED);

$result = $task->mapStatusToAllowedActions(Task::STATUS_DONE);
$expected = [];
assertTest($result, $expected, 'Unexpected map of actions for status ' . Task::STATUS_DONE);

$result = $task->mapStatusToAllowedActions(Task::STATUS_FAILED);
$expected = [];
assertTest($result, $expected, 'Unexpected map of actions' . Task::STATUS_FAILED);
