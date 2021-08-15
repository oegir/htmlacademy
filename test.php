<?php
require_once 'Task.php';

//Новое задание с id заказяика 1 и id исполнителя 23
$task = new TaskForce\Task(1, 23);
//стартуем задание
echo $task->start(), \PHP_EOL;
//отменим задание, которое выполняется. Д.б. выброшено исключение
echo $task->cancel(), \PHP_EOL;
//завершим задание
echo $task->complete(), \PHP_EOL;
?>
