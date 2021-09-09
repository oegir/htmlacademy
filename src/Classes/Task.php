<?php

namespace Service;
require_once "vendor/autoload.php";


class Task
{
    public $actions = [];
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

    private $actionMap = [AbortAction::ACTION_ABORT=>AbortAction::ACTION_ABORT_READABLE,ResponseAction::ACTION_RESPONSE=>ResponseAction::ACTION_RESPONSE_READABLE,CompleteAction::ACTION_COMPLETE=>CompleteAction::ACTION_COMPLETE_READABLE,FailAction::ACTION_FAILURE=>FailAction::ACTION_FAILURE_READABLE];

    public function __construct($clientId, $workerId)
    {
        $this->clientId = $clientId;
        $this->workerId = $workerId;
    }

// Переработаны действия-функции заказчика и исполнителя объединены
    public function addAction(Actions $action)
    {
        $this->actions[] = $action;
    }

    public function nextStatus($action, $requestId)
    {
        $newStatus = null;
        $statusSwitch = ["Завершить задание" => self::STATUS_COMPLETED, "Отказаться" => self::STATUS_FAILED, "Отменить задание" => self::STATUS_ABORTED, "Откликнуться" => self::STATUS_IN_WORK];
        foreach ($this->actions as $key) {

            if ($key->getInnerName() == $action) {
                if ($key->rightsCheck($this->clientId, $this->workerId, $this->status, $requestId)) {
                    $this->status = $statusSwitch[$key->getReadableName()];
                    return $this->status;
                }
            }
        }
            return self::ACTION_WRONG;
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
        foreach ($this->actions as $action) {
            if ($action->rightsCheck($this->clientId, $this->workerId, $this->status, $requestId)) {
                $result[] = $action->getInnerName();
            };
        }
        return $result;
    }
}
