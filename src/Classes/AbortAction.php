<?php


namespace Service;


class AbortAction extends Actions
{
    const ACTION_ABORT="Abort";
    const ACTION_ABORT_READABLE="Отменить";

    public function rightsCheck($clientId, $workerId, $status, $requestId)
    {
        return $status == Task::STATUS_NEW && $clientId == $requestId;
    }
    public function getInnerName(){
        return ACTION_ABORT;
    }
     public function getReadableName(){
        return ACTION_ABORT_READABLE;
    }
}
