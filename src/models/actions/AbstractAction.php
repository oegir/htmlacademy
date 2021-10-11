<?php

namespace taskforce\models\actions;

use taskforce\models\Task;

abstract class AbstractAction
{
    abstract public function getValue() :string;
    abstract public function getName() :string;
    abstract public function checkPermission(int $worker_id, int $customer_id, int $user_id) :bool;
}