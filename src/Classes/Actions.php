<?php


namespace Service;


abstract class Actions
{
    /**
     * @param int $clientId customer user id
     * @param int $workerId worker user id
     * @param int $userId current user id
     */
    abstract public function rightsCheck(int $clientId, int $workerId, int $userId): bool;

    abstract public function getReadableName(): string;

    abstract public function getInnerName(): string;


}
