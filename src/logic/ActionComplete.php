<?php

namespace TaskForce\logic;

use TaskForce\logic\Action;

class ActionComplete extends Action
{
    public function checkActionRights(int $customerId, int $contractorId, int $userId): bool
    {
        return $customerId == $userId;
    }

    public function getName(): string
    {
        return self::ACTION_COMPLETE;
    }

    public function getTitle(): string
    {
        return self::$actionMap[self::ACTION_COMPLETE];
    }
}
