<?php


namespace Service;


class ResponseAction extends Actions
{
    const ACTION_RESPONSE = "Response";
    const ACTION_RESPONSE_READABLE = "Откликнуться";

    public function rightsCheck($clientId, $workerId, $status, $requestId)
    {
        return ($status == Task::STATUS_NEW || $status == Task::STATUS_FAILED)/* && !$workerId*/ ;
    }

    public function getInnerName()
    {
        return self::ACTION_RESPONSE;
    }

    public function getReadableName()
    {
        return self::ACTION_RESPONSE_READABLE;
    }
}
