<?php


namespace Service;



class FailAction extends Actions
{
    const ACTION_FAILURE = "Failure";
    const ACTION_FAILURE_READABLE="Провалить задание";

    public function rightsCheck($clientId, $workerId, $status, $requestId)
    {
        return $status == Task::STATUS_IN_WORK && $workerId == $requestId;
    }
    public function getInnerName(){
    return ACTION_FAILURE;
    }
    public function getReadableName(){
        return ACTION_FAILURE_READABLE;
    }
}
