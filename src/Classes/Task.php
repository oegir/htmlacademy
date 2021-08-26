<?php

namespace Service;
require_once "vendor/autoload.php";


class Task
{
    public $response, $abort, $fail, $complete;
//Возможные статусы
    const STATUS_NEW = "New";
    const STATUS_ABORTED = "Aborted";
    const STATUS_IN_WORK = "In work";
    const STATUS_COMPLETED = "Completed";
    const STATUS_FAILED = "Failed";
//Возможные действия
    const ACTION_WRONG = "Wrong Action!";
//свойства-идентификаторы
    private $clientId, $workerId;
    private $status = self::STATUS_NEW;

    private $statusMap = [self::STATUS_NEW => "Новая", self::STATUS_ABORTED => "Отменена", self::STATUS_IN_WORK => "В работе", self::STATUS_COMPLETED => "Выполнено", self::STATUS_FAILED => "Не выполнено"];

    private $actionMap = [];

    public function __construct($clientId, $workerId)
    {
        $this->clientId = $clientId;
        $this->workerId = $workerId;
        $this->response = new ResponseAction("actResponse", "Откликнуться");
        $this->abort = new AbortAction("actAbort", "Отменить задание");
        $this->fail = new FailAction("actFail", "Отказаться");
        $this->complete = new CompleteAction("actComplete", "Выполнить");
        $this->actionMap = [$this->response, $this->abort, $this->fail, $this->complete];
    }

// Переработаны действия-функции заказчика и исполнителя объединены
    public function nextStatus($action, $requestId)
    {
        $newStatus = null;
        switch ($action) {
            case $this->abort->getInnerName():
                if ($this->abort->rightsCheck($this->clientId, $this->workerId, $this->status, $requestId)) {
                    $newStatus = self::STATUS_ABORTED;
                } else {
                    $newStatus = self::ACTION_WRONG;
                    return $newStatus;
                }
                break;
            case $this->complete->getInnerName():
                if ($this->complete->rightsCheck($this->clientId, $this->workerId, $this->status, $requestId)) {
                    $newStatus = self::STATUS_COMPLETED;
                } else {
                    $newStatus = self::ACTION_WRONG;
                    return $newStatus;
                }
                break;
            case $this->response->getInnerName():
                if ($this->response->rightsCheck($this->clientId, $this->workerId, $this->status, $requestId)) {
                    $newStatus = self::STATUS_IN_WORK;
                } else {
                    $newStatus = self::ACTION_WRONG;
                    return $newStatus;
                }
                break;
            case $this->fail->getInnerName():
                if ($this->fail->rightsCheck($this->clientId, $this->workerId, $this->status, $requestId)) {
                    $newStatus = self::STATUS_FAILED;
                } else {
                    $newStatus = self::ACTION_WRONG;
                    return $newStatus;
                }
                break;
            default:
                $newStatus = self::ACTION_WRONG;
        }
        if ($newStatus != self::ACTION_WRONG) {
            $this->status = $newStatus;
            return $this->status;
        } else {
            return self::ACTION_WRONG;
        }
    }

    public function getActionMap()
    {
        return $this->actionMap;

    }

    public function getStatusMap()
    {
        return $this->statusMap;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function actions($requestId)//метод который возвращает доступные действия
    {
        $result = [];
        foreach($this->actionMap as $action){if($action->rightsCheck($this->clientId, $this->workerId, $this->status, $requestId)){$result[]=$action->getInnerName();};}
        return $result;
    }
}
