<?php
require_once("vendor/autoload.php");
// настройка assert
assert_options(ASSERT_ACTIVE, 1);
function assertMessage($file, $line, $code = null, $desc = null)
{
    echo ($desc ? "$desc - " : '') . " line" . $line . "File $file" . PHP_EOL;
}

assert_options(ASSERT_CALLBACK, 'assertMessage');
$task = new Classes\Task("Client", "Worker");

//проверка статуса
try {
    $status = $task->getStatus();
    assert($status == $task::STATUS_NEW, 'Wrong task status. Expected "' . $task::STATUS_NEW . '", got "' . $status . '"');
} catch (Error $e) {
};
//проверка работы actions()
try {
    $actions = $task->actions();
    $expected = [$task::ACTION_ABORT, $task::ACTION_RESPONSE];
    assert($actions == $expected, 'Wrong task actions. Expected "' . print_r($expected, true) . '", got "' . print_r($actions, true) . '"');

} catch (Error $e) {
};
//проверка реакции на неверные команды
try {
    $actions = $task->nextStatus($task::ACTION_FAILURE);
    assert($actions == $task::ACTION_WRONG, 'This change not allowed');
} catch (Error $e) {
}
//проверка работы nextStatus() и переходов между статусами
try {
    $actions = $task->nextStatus($task::ACTION_RESPONSE);
    assert($actions == $task::STATUS_IN_WORK, 'Wrong task status. Expected "' . $task::STATUS_IN_WORK . '", got "' . $actions . '"');

} catch (Error $e) {
};
try {
    $status = $task->getStatus();
    assert($status == $task::STATUS_IN_WORK, 'Wrong task status. Expected "' . $task::STATUS_IN_WORK . '", got "' . $status . '"');
    $actions = $task->actions();
    $expected = [$task::ACTION_FAILURE, $task::ACTION_COMPLETE];
    assert($actions == $expected, 'Wrong $ask actions. Expected "' . print_r($expected, true) . '", got "' . print_r($actions, true) . '"');
} catch (Error $e) {
};
// проверка работы actions()
try {
    $actions = $task->actions();
    $expected = [$task::ACTION_FAILURE, $task::ACTION_COMPLETE];
    assert($actions == $expected, 'Wrong task actions. Expected "' . print_r($expected, true) . '", got "' . print_r($actions, true) . '"');

} catch (Error $e) {
};
try {
    $actions = $task->nextStatus($task::ACTION_COMPLETE);
    assert($actions == $task::STATUS_COMPLETED, 'Wrong task status. Expected "' . $task::STATUS_COMPLETED . '", got "' . $actions . '"');

} catch (Error $e) {
};
//проверка реакции на неверные команды
try {
    $actions = $task->nextStatus($task::ACTION_FAILURE);
    assert($actions == $task::ACTION_WRONG, 'This change not allowed');

} catch (Error $e) {
};
echo 'Tests finished' . PHP_EOL;
