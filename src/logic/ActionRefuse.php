<?php

namespace TaskForce\logic;

use TaskForce\logic\Action;

class ActionRefuse extends Action
{
    public function checkActionRights(int $customerId, int $contractorId, int $userId): bool
    {
        return $contractorId == $userId;
    }

    public function getName(): string
    {
        return 'refuse';
    }

    public function getTitle(): string
    {
        return 'отказаться от задания';
    }
}
