<?php


namespace Service;


abstract class Actions
{

    abstract public function rightsCheck($clientId, $workerId, $status, $requestId);

    abstract public function getReadableName();

    abstract public function getInnerName();


}
