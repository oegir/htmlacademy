<?php

// ; ----------------------------
// ; Assertion
// ; ----------------------------

// assert.active                = on
// assert.bail                  = off
// assert.callback              = "assert_handler"
// assert.exception             = off
// assert.warning               = off
// zend.assertions              = 1

require_once('classes/Task.php');
require_once('functions.php');
require_once('defined.php');

$task = new Task(1, 666);

assert($task->getStatusMap() === TASK_STATUS_MAP);
assert($task->getActionMap() === TASK_ACTION_MAP);

assert($task->getNextStatus('action_cancel') === 'cancel');
assert($task->getNextStatus('action_respond') === 'work');
assert($task->getNextStatus('action_done') === 'done');
assert($task->getNextStatus('action_refuse') === 'failed');

assert($task->getAvailableActions('new') === ['action_cancel', 'action_respond']);
assert($task->getAvailableActions('work') === ['action_done', 'action_refuse']);
