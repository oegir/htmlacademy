<?php

ini_set('display_erros', 1);
ini_set('error_reporing', E_ALL);

require_once('classes/Task.php');

$task = new Task(1, 666);

print('<pre>');

print("Executor id: {$task->executor_id}<br>");
print("Customer id: {$task->customer_id}<br>");
print("Current status: {$task->current_status}<hr>");

print_r($task->getStatusMap());
print('<hr>');
print_r($task->getActionMap());
print('<hr>');

print("Next status for action \"cancel\": {$task->getNextStatus('action_cancel')}<br>");
print("Next status for action \"respond\": {$task->getNextStatus('action_respond')}<br>");
print("Next status for action \"done\": {$task->getNextStatus('action_done')}<br>");
print("Next status for action \"refuse\": {$task->getNextStatus('action_refuse')}<hr>");

print('Available actions for status "new":<br>');
print_r($task->getAvailableActions('new'));
print('Available actions for status "work":<br>');
print_r($task->getAvailableActions('work'));

print('</pre>');
