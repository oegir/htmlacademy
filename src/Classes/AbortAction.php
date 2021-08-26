<?php


namespace Service;


class AbortAction extends Actions
{

    public function rightsCheck($clientId, $workerId, $status, $requestId)
    {
        return $status == Task::STATUS_NEW && $clientId == $requestId;
    }
}
