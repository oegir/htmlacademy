<?php


namespace Service;


abstract class Actions
{
    public $innerName, $externalName;

    function __construct($innerName, $externalName)
    {
        $this->innerName = $innerName;
        $this->externalName = $externalName;
    }

    abstract public function rightsCheck($clientId, $workerId, $status, $requestId);

    public function getExternalName()
    {
        return $this->externalName;
    }

    public function getInnerName()
    {
        return $this->innerName;
    }

}
