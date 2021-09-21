<?php

namespace TaskForce\logic;

use TaskForce\logic\Action;

class ActionStart extends Action
{
    public function checkActionRights(int $customerId, int $contractorId, int $userId): bool
    {
        return $customerId == $userId;
    }

    public function getName(): string
    {
        return 'start';
    }

    public function getTitle(): string
    {
        return 'стартовать задание';
    }
}
