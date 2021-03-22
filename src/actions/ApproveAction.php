<?php


namespace taskforce\actions;


use taskforce\Task;

class ApproveAction extends AbstractAction
{
    public function getValue() :string
    {
        return 'approve';
    }

    public function getName() :string
    {
        return 'Утвердить';
    }

    public function checkPermission(int $worker_id, int $customer_id, int $user_id) :bool
    {
        return $customer_id === $user_id;
    }
}