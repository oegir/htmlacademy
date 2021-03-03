<?php
// Активация утверждений и отключение вывода ошибок
assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 0);
assert_options(ASSERT_QUIET_EVAL, 1);
// Создание обработчика
function my_assert_handler($file, $line, $code, $desc = null) {
    print_r($desc);
}
// Подключение callback-функции
assert_options(ASSERT_CALLBACK, 'my_assert_handler');

require 'src'.DIRECTORY_SEPARATOR.'Task.php'; 

$task = new Task(1, 2);

assert($task->getNextStatus(Task::ACTION_APPROVE, Task::CUSTOMER_ROLE) == Task::STATUS_IN_WORK, 'Approve action failed');