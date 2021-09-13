<?php
use Service\AbortAction;
use Service\Task;

require_once("vendor/autoload.php");
// настройка assert
assert_options(ASSERT_ACTIVE, 1);
function assertMessage($file, $line, $code = null, $desc = null)
{
    echo ($desc ? "$desc - " : '') . " line" . $line . "File $file" . PHP_EOL;
}

assert_options(ASSERT_CALLBACK, 'assertMessage');

$clidentId = 1;
$worlerId = 2;

$task = new Service\Task($clidentId, $worlerId);
$task->addAction(new Service\CompleteAction());
$task->addAction(new Service\FailAction());
$task->addAction(new Service\AbortAction());
$task->addAction(new Service\ResponseAction());

//проверка статуса
try {
    $status = $task->getStatus();
    assert($status == $task::STATUS_NEW, 'Wrong task status. Expected "' . $task::STATUS_NEW . '", got "' . $status . '"');
} catch (Error $e) {
};
//проверка работы actions()
try {
    $currentUserId = 2;
    $task->setStatus(Task::STATUS_NEW);
    $actions = $task->actions($currentUserId);
    
    $count = count($actions);
    assert($count == 1, 'Wrong task actions number. Expected 1, got "' . count($actions) . '"');
    $action = array_shift($actions);
    assert($action instanceof AbortAction, 'Wrong task actions type. Expected `AbortAction`, got "' . gettype($action) . '"');

} catch (Error $e) {
};
//проверка реакции на неверные команды
try {
    $actions = $task->nextStatus("Failure", "Client");
    assert($actions == $task::ACTION_WRONG, 'This change not allowed');
} catch (Error $e) {
}
//проверка работы nextStatus() и переходов между статусами
try {
    $task->nextStatus("Response", "Worker");
    $status = $task->getStatus();
    assert($status == $task::STATUS_IN_WORK, 'Wrong task status. Expected "' . $task::STATUS_IN_WORK . '", got "' . $task->getStatus() . '"');

    assert($status == $task::STATUS_IN_WORK, 'Wrong task status. Expected "' . $task::STATUS_IN_WORK . '", got "' . $task->getStatus() . '"');

} catch (Error $e) {
};

try {
    $status = $task->getStatus();
    assert($status == $task::STATUS_IN_WORK, 'Wrong task status. Expected "' . $task::STATUS_IN_WORK . '", got "' . $status . '"');
    $actions = $task->actions("Client");
    $expected = $task->actions->getInnerName();
    assert($actions[0] == $expected, 'Wrong $ask actions. Expected "' . print_r($expected, true) . '", got "' . print_r($actions[0], true) . '"');
} catch (Error $e) {
};
// проверка работы actions()
try {
    $actions = $task->nextStatus("Complete", "Client");
    assert($actions == $task::STATUS_COMPLETED, 'Wrong task status. Expected "' . $task::STATUS_COMPLETED . '", got "' . $actions . '"');

} catch (Error $e) {
};
//проверка реакции на неверные команды
try {
    $actions = $task->nextStatus("Failure", "Client");
    assert($actions == $task::ACTION_WRONG, 'This change not allowed');

} catch (Error $e) {
};
echo 'Tests finished' . PHP_EOL;
