<?php


namespace Service;


class AbortAction extends Actions
{
    const INNER_NAME = "Abort";
    const READABLE_NAME = "Отменить";

    public function rightsCheck(int $clientId, int $workerId, int $userId): bool
    {
        // Only client can interrupt his task 
        return $userId == $clientId;
    }

    public function getInnerName()
    {
        return self::INNER_NAME;
    }

    public function getReadableName()
    {
        return self::READABLE_NAME;
    }
}
