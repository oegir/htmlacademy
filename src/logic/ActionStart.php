<?php

namespace TaskForce\logic;

use TaskForce\logic\Action;

class ActionStart extends Action
{
    public const ACTION_START = 'start';

    public function checkActionRights(int $customerId, int $contractorId, int $userId): bool
    {
        return $customerId == $userId;
    }

    public function getName(): string
    {
        return self::ACTION_START;
    }

    public function getTitle(): string
    {
        return 'стартовать задание';
    }
}
