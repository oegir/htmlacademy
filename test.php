<?php
assert_options(ASSERT_ACTIVE,   true);
assert_options(ASSERT_BAIL,     1);
assert_options(ASSERT_WARNING,  false);
assert_options(ASSERT_CALLBACK, 'assert_failure');

require 'src\Task.php';

$task = new Task(1, 2);


// Тестовая функция
function assert_failure()
{
    echo 'Проверка провалена';
}

// Тестовая функция
function test_assert($parameter)
{
    assert(is_bool($parameter));
}

test_assert(1);
echo 'Никогда не будет выведено';



//	echo '<pre>';
//
//	print_r($task::ACTION_CANCEL);
//
//	print_r($task::STATUS_IN_WORK);

echo $task->getNextStatus('done') . '<br>';

print_r($task->getNextStatus("done"));

assert($task->getNextStatus("done") == Task::STATUS_DONE, 'Ожидайте действие: "in work"');
assert($task->getNextStatus("cancel") == Task::STATUS_CANCEL, 'Ожидайте действие: "cancel"');
