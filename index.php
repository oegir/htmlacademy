<?php
require_once 'task.php';

function includeTemplate(string $name)
{
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    require $name;

    $result = ob_get_clean();

    return $result;
}

//Новое задание с id заказяика 1
$task = new TaskForce\Task(1);
//стартуем задание
//id исполнителя не задан, поэтому д.б. выброшено исключение
try {
    $task->start();
} catch (\LogicException $e) {
    echo  'start() перехвачено исключение: ', $e->getMessage(), TaskForce\PHP_EOL;
}
//Зададим id исполнителя
$task->setContractor(12);
//завершим задание. Д.б. выброшено исключение, т.к. еще оно не стартовало
$task->complete();
//снова стартуем задание, д.б. ОК
$task->start();
//зададим id другого исполнителя. Д.б. выброшено исключение
try {
    $task->setContractor(11);
} catch (\LogicException $e) {
    echo  'setContractor() перехвачено исключение: ', $e->getMessage(), TaskForce\PHP_EOL;
}
//исполнитель провалил задание
$task->refuse();
//снова стартуем проваленное задание. Д.б. выброшено исключение
$task->start();
//обновим задание. Д.б. ОК
$task->renew();
//стартуем обновленное задание
//id исполнителя не задан, поэтому д.б. выброшено исключение
try {
    $task->start();
} catch (\LogicException $e) {
    echo  'start() перехвачено исключение: ', $e->getMessage(), TaskForce\PHP_EOL;
}
//отменим задание
$task->cancel();
//обновим отмененное задание. Д.б. выброшено исключение
$task->renew();

$main = includeTemplate('test.php');
print($main);