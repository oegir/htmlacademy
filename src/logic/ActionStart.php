<?php

namespace TaskForce\logic;

use TaskForce\logic\Action;

class ActionStart extends Action
{
    public function checkActionRights(int $customerId, int $contractorId, int $userId)
    {
        return $customerId == $userId;
    }

    public function getName(): string
    {
        return self::ACTION_START;
    }

    public function getTitle(): string
    {
        return self::$actionMap[self::ACTION_START];
    }
}
