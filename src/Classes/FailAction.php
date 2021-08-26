<?php


namespace Service;


class FailAction extends Actions
{

    public function rightsCheck($clientId, $workerId, $status, $requestId)
    {
        return $status == Task::STATUS_IN_WORK && $workerId == $requestId;
    }
}
