<?php

namespace TaskForce\logic;

use TaskForce\logic\Action;

class ActionCancel extends Action
{
    public function checkActionRights(int $customerId, int $contractorId, int $userId): bool
    {
        return $customerId == $userId;
    }

    public function getName(): string
    {
        return self::ACTION_CANCEL;
    }

    public function getTitle(): string
    {
        return self::$actionMap[self::ACTION_CANCEL];
    }
}
