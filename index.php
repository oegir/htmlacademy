<?php
assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 0);
assert_options(ASSERT_QUIET_EVAL, 1);

require 'src\Task.php';

$task = new Task(1, 2);

	echo '<pre>';

	print_r($task::STAUS_NAME);

	print_r($task::ACTION_NAME);

    print_r($task->getNextStatus("new"));


assert($task->getNextStatus("done") !== Task::STATUS_DONE, 'Ожидайте действие: "in work"');
assert($task->getNextStatus("cancel") == Task::STATUS_CANCEL, 'Ожидайте действие: "cancel"');

