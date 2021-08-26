<?php
require_once("vendor/autoload.php");
// настройка assert
assert_options(ASSERT_ACTIVE, 1);
function assertMessage($file, $line, $code = null, $desc = null)
{
    echo ($desc ? "$desc - " : '') . " line" . $line . "File $file" . PHP_EOL;
}

assert_options(ASSERT_CALLBACK, 'assertMessage');
$task = new Service\Task("Client", "Worker");

//проверка статуса
try {
    $status = $task->getStatus();
    assert($status == $task::STATUS_NEW, 'Wrong task status. Expected "' . $task::STATUS_NEW . '", got "' . $status . '"');
} catch (Error $e) {
};
//проверка работы actions()
try {
    $actions = $task->actions("Worker");
    $expected = $task->response->getInnerName();
    assert($actions[0] == $expected, 'Wrong task actions. Expected "' . print_r($expected, true) . '", got "' . print_r($actions[0], true) . '"');

} catch (Error $e) {
};
//проверка реакции на неверные команды
try {
    $actions = $task->nextStatus("actFail", "Client");
    assert($actions == $task::ACTION_WRONG, 'This change not allowed');
} catch (Error $e) {
}
//проверка работы nextStatus() и переходов между статусами
echo $task->getStatus() . "</br>";
try {
    $task->nextStatus("actResponse", "Worker");
    $status = $task->getStatus();
    assert($status == $task::STATUS_IN_WORK, 'Wrong task status. Expected "' . $task::STATUS_IN_WORK . '", got "' . $task->getStatus() . '"');

    assert($status == $task::STATUS_IN_WORK, 'Wrong task status. Expected "' . $task::STATUS_IN_WORK . '", got "' . $task->getStatus() . '"');

} catch (Error $e) {
};
try {
    $status = $task->getStatus();
    assert($status == $task::STATUS_IN_WORK, 'Wrong task status. Expected "' . $task::STATUS_IN_WORK . '", got "' . $status . '"');
    $actions = $task->actions("Client");
    $expected = $task->complete->getInnerName();
    assert($actions[0] == $expected, 'Wrong $ask actions. Expected "' . print_r($expected, true) . '", got "' . print_r($actions[0], true) . '"');
} catch (Error $e) {
};
// проверка работы actions()
try {
    $actions = $task->nextStatus("actComplete", "Client");
    assert($actions == $task::STATUS_COMPLETED, 'Wrong task status. Expected "' . $task::STATUS_COMPLETED . '", got "' . $actions . '"');

} catch (Error $e) {
};
//проверка реакции на неверные команды
try {
    $actions = $task->nextStatus("actFail", "Client");
    assert($actions == $task::ACTION_WRONG, 'This change not allowed');

} catch (Error $e) {
};
echo 'Tests finished' . PHP_EOL;
