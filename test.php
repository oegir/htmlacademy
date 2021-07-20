<?php
require_once("Tasks\Task.php");
// настройка assert
assert_options(ASSERT_ACTIVE, 1);
function assertMessage($file, $line, $code = null, $desc = null)
{
    echo ($desc ? "$desc - " : '') . " line" . $line . "File $file" . PHP_EOL;
}

assert_options(ASSERT_CALLBACK, 'assertMessage');
$task = new Task("Client", "Worker");
//проверка статуса
try {
    $status = $task->getStatus();
    assert($status == Task::STATUS_NEW, 'Wrong task status. Expected "' . Task::STATUS_NEW . '", got "' . $status . '"');
} catch (Error $e) {
};
//проверка работы actions()
try {
    $actions = $task->actions();
    $expected = [Task::ACTION_ABORT, Task::ACTION_RESPONSE];
    assert($actions == $expected, 'Wrong task actions. Expected "' . print_r($expected, true) . '", got "' . print_r($actions, true) . '"');

} catch (Error $e) {
};
//проверка реакции на неверные команды
try {
    $actions = $task->nextStatus(Task::ACTION_FAILURE);
    assert($actions == Task::ACTION_WRONG, 'This change not allowed');
} catch (Error $e) {
}
//проверка работы nextStatus() и переходов между статусами
try {
    $actions = $task->nextStatus(Task::ACTION_RESPONSE);
    assert($actions == Task::STATUS_IN_WORK, 'Wrong task status. Expected "' . Task::STATUS_IN_WORK . '", got "' . $actions . '"');

} catch (Error $e) {
};
try {
    $status = $task->getStatus();
    assert($status == Task::STATUS_IN_WORK, 'Wrong task status. Expected "' . Task::STATUS_IN_WORK . '", got "' . $status . '"');
    $actions = $task->actions();
    $expected = [Task::ACTION_FAILURE, Task::ACTION_COMPLETE];
    assert($actions == $expected, 'Wrong task actions. Expected "' . print_r($expected, true) . '", got "' . print_r($actions, true) . '"');
} catch (Error $e) {
};
// проверка работы actions()
try {
    $actions = $task->actions();
    $expected = [Task::ACTION_FAILURE, Task::ACTION_COMPLETE];
    assert($actions == $expected, 'Wrong task actions. Expected "' . print_r($expected, true) . '", got "' . print_r($actions, true) . '"');

} catch (Error $e) {
};
try {
    $actions = $task->nextStatus(Task::ACTION_COMPLETE);
    assert($actions == Task::STATUS_COMPLETED, 'Wrong task status. Expected "' . Task::STATUS_COMPLETED . '", got "' . $actions . '"');

} catch (Error $e) {
};
//проверка реакции на неверные команды
try {
    $actions = $task->nextStatus(Task::ACTION_FAILURE);
    assert($actions == Task::ACTION_WRONG, 'This change not allowed');

} catch (Error $e) {
};
echo 'Tests finished' . PHP_EOL;
