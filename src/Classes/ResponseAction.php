<?php


namespace Service;


class ResponseAction extends Actions
{

    public function rightsCheck($clientId, $workerId, $status, $requestId)
    {
        return ($status == Task::STATUS_NEW || $status == Task::STATUS_FAILED)/* && !$workerId*/ ;
    }
}
