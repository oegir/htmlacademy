<?php


namespace Service;



class CompleteAction extends Actions
{
    const ACTION_COMPLETE = "Complete";
    const ACTION_COMPLETE_READABLE="Завершить задание";

    public function rightsCheck($clientId, $workerId, $status, $requestId)
    {
        return $status == Task::STATUS_IN_WORK && $workerId && $clientId == $requestId;
    }
    public function getInnerName(){
    return ACTION_COMPLETE;
    }
    public function getReadableName(){
        return ACTION_COMPLETE_READABLE;
    }
}
