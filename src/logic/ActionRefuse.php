<?php

namespace TaskForce\logic;

use TaskForce\logic\Action;

class ActionRefuse extends Action
{
    public const ACTION_REFUSE = 'refuse';

    public function checkActionRights(int $customerId, int $contractorId, int $userId): bool
    {
        return $contractorId == $userId;
    }

    public function getName(): string
    {
        return self::ACTION_REFUSE;
    }

    public function getTitle(): string
    {
        return 'отказаться от задания';
    }
}
