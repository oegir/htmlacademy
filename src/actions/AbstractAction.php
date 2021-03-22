<?php

namespace taskforce\actions;

use taskforce\Task;

abstract class AbstractAction
{
    abstract public function getValue() :string;
    abstract public function getName() :string;
    abstract public function checkPermission(int $worker_id, int $customer_id, int $user_id) :bool;
}