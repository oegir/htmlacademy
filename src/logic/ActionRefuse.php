<?php

namespace TaskForce\logic;

use TaskForce\logic\Action;

class ActionRefuse extends Action
{
    public function checkActionRights(int $customerId, int $contractorId, int $userId)
    {
        return $contractorId == $userId;
    }

    public function getName(): string
    {
        return self::ACTION_REFUSE;
    }

    public function getTitle(): string
    {
        return self::$actionMap[self::ACTION_REFUSE];
    }
}
