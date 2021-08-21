<?php

use TaskForce\logic\Task;

require_once 'vendor/autoload.php';

/**
 * Проверка ожидаемого результата
 * @param mixed $result некоторое значение переменной
 * @param mixed $expected ожидаемое значение переменной
 * @param string $msg сообщение в случае неовпадения значений
 */
function assertTest($result, $expected, $msg) {
    assert($result === $expected, $msg);
}

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
    assertTest($result, $statusMap, 'Unexpected statuses map 1');
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
    assertTest($result, $actionMap, 'Unexpected actions map 2');
} catch (AssertionError $e) {
    echo $e->getMessage(), \PHP_EOL;
}
try {
    $task = new Task(1, 23);
    $result = $task->mapActionToStatus(Task::ACTION_START);
    $expected = Task::STATUS_WORK;
    assertTest($result, $expected, 'Unexpected status for action ' . Task::ACTION_START);
} catch (AssertionError $e) {
    echo $e->getMessage(), \PHP_EOL;
}
try {
    $task = new Task(1, 23);
    $result = $task->mapActionToStatus(Task::ACTION_COMPLETE);
    $expected = Task::STATUS_DONE;
    assertTest($result, $expected, 'Unexpected status for action ' . Task::ACTION_COMPLETE);
} catch (AssertionError $e) {
    echo $e->getMessage(), \PHP_EOL;
}
try {
    $task = new Task(1, 23);
    $result = $task->mapActionToStatus(Task::ACTION_REFUSE);
    $expected = Task::STATUS_FAILED;
    assertTest($result, $expected, 'Unexpected status for action ' . Task::ACTION_REFUSE);
} catch (AssertionError  $e) {
    echo $e->getMessage(), \PHP_EOL;
}
try {
    $task = new Task(1, 23);
    $result = $task->mapActionToStatus(Task::ACTION_CANCEL);
    $expected = Task::STATUS_CANCELED;
    assertTest($result, $expected, 'Unexpected status for action ' . Task::ACTION_CANCEL);
} catch (AssertionError  $e) {
    echo $e->getMessage(), \PHP_EOL;
}
try {
    $task = new Task(1, 23);
    $result = $task->mapStatusToAllowedActions(Task::STATUS_NEW);
    $expected = [Task::ACTION_START, Task::ACTION_CANCEL];
    assertTest($result, $expected, 'Unexpected map of actions for status ' . Task::STATUS_NEW);
} catch (AssertionError  $e) {
    echo $e->getMessage(), \PHP_EOL;
}
try {
    $task = new Task(1, 23);
    $result = $task->mapStatusToAllowedActions(Task::STATUS_WORK);
    $expected = [Task::ACTION_COMPLETE, Task::ACTION_REFUSE];
    assertTest($result, $expected, 'Unexpected map of actions for status ' . Task::STATUS_WORK);
} catch (AssertionError  $e) {
    echo $e->getMessage(), \PHP_EOL;
}
try {
    $task = new Task(1, 23);
    $result = $task->mapStatusToAllowedActions(Task::STATUS_CANCELED);
    $expected = [];
    assertTest($result, $expected, 'Unexpected map of actions for status ' . Task::STATUS_CANCELED);
} catch (AssertionError  $e) {
    echo $e->getMessage(), \PHP_EOL;
}
try {
    $task = new Task(1, 23);
    $result = $task->mapStatusToAllowedActions(Task::STATUS_DONE);
    $expected = [];
    assertTest($result, $expected, 'Unexpected map of actions for status ' . Task::STATUS_DONE);
} catch (AssertionError  $e) {
    echo $e->getMessage(), \PHP_EOL;
}
try {
    $task = new Task(1, 23);
    $result = $task->mapStatusToAllowedActions(Task::STATUS_FAILED);
    $expected = [];
    assertTest($result, $expected, 'Unexpected map of actions' . Task::STATUS_FAILED);
} catch (AssertionError  $e) {
    echo $e->getMessage(), \PHP_EOL;
}
