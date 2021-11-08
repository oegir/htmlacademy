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

use Anatolev\Service\{ActCancel, ActDone, ActRefuse, ActRespond};

require_once('vendor/autoload.php');
require_once('functions.php');
require_once('define.php');

$task = new Anatolev\Service\Task(1, 2);

assert($task->getStatusMap() === TASK_STATUS_MAP);
assert($task->getActionMap() === TASK_ACTION_MAP);

assert($task->getNextStatus('act_cancel') === 'cancel');
assert($task->getNextStatus('act_respond') === 'work');
assert($task->getNextStatus('act_done') === 'done');
assert($task->getNextStatus('act_refuse') === 'failed');

assert($task->getAvailableAction('new', 1) instanceof ActRespond);
assert($task->getAvailableAction('new', 2) instanceof ActCancel);
assert($task->getAvailableAction('new', 3) === null);

assert($task->getAvailableAction('work', 1) instanceof ActRefuse);
assert($task->getAvailableAction('work', 2) instanceof ActDone);
assert($task->getAvailableAction('work', 3) === null);
