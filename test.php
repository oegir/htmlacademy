<?php
require_once("Tasks/task3.php");
function isTaskCorrect()
{
    $task = new Task("Client", "Worker");
    if (assert($task->status() == "Новая", 'new task') &&
        assert($task->actions("Response", "Client") === "Недоступная команда", 'Client not allowed to take his job') &&
        assert($task->actions("Response", "Worker") == $task::STATUS_IN_WORK, 'Worker accepted task') &&
        assert($task->status() == "В работе", 'task in work') &&
        assert($task->actions("Failure", "Client") === "Недоступная команда", 'Client can`t fail task') &&
        assert($task->actions("Abort", "Worker") === "Недоступная команда", 'Worker can`t abort task') &&
        assert($task->actions("Failure", "Worker") == $task::STATUS_FAILED, 'Worker fail task') &&
        assert($task->actions("Complete", "Client") === "Задание не в работе!", 'Client can`t accept failed task'))
        {
        return "Corrected Task!";
    } else {
        return "Uncorrected Task!";
    }
}
?>
