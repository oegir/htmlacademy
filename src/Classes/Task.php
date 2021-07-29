<?php

namespace Classes;
class Task
{
    //Возможные статусы
    const STATUS_NEW = "New";
    const STATUS_ABORTED = "Aborted";
    const STATUS_IN_WORK = "In work";
    const STATUS_COMPLETED = "Completed";
    const STATUS_FAILED = "Failed";
    //Возможные действия
    const ACTION_RESPONSE = "Response";
    const ACTION_ABORT = "Abort";
    const ACTION_FAILURE = "Failure";
    const ACTION_COMPLETE = "Complete";
    const ACTION_WRONG = "Wrong Action!";
    //свойства-идентификаторы
    private $clientId, $workerId;//исправлено:убран blacklist, Client вместо User
    private $status = self::STATUS_NEW;
    //исправлены карты статуса -в качеcтве ключа теперь константа
    private $statusMap = [self::STATUS_NEW => "Новая", self::STATUS_ABORTED => "Отменена", self::STATUS_IN_WORK => "В работе", self::STATUS_COMPLETED => "Выполнено", self::STATUS_FAILED => "Не выполнено"];
    //исправлены карты действий-в качестве ключа теперь константа + упрощение карты
    private $actionMap = [self::ACTION_RESPONSE => "Откликнуться", self::ACTION_ABORT => "Отмененить", self::ACTION_FAILURE => "Отказаться", self::ACTION_COMPLETE => "Выполненить"];

    public function __construct($clientId, $workerId)
    {
        $this->clientId = $clientId;
        $this->workerId = $workerId;
    }//исправление конструктора-при создании новой функции задается исполнитель

    // Переработаны действия-функции заказчика и исполнителя объединены
    public function nextStatus($action)
    {
        $result = null;
        switch ($action) {
            case self::ACTION_ABORT:
                if ($this->status == self::STATUS_NEW) {
                    $result = self::STATUS_ABORTED;
                }
                break;
            case self::ACTION_COMPLETE:
                if ($this->status == self::STATUS_IN_WORK) {
                    $result = self::STATUS_COMPLETED;
                }
                break;
            case self::ACTION_RESPONSE:
                if ($this->status == self::STATUS_NEW || $this->status == self::STATUS_FAILED) {
                    $result = self::STATUS_IN_WORK;
                }
                break;
            case self::ACTION_FAILURE:
                if ($this->status == self::STATUS_IN_WORK) {
                    $result = self::STATUS_FAILED;
                }
                break;
            default:
                return self::ACTION_WRONG;
        }
        if ($result != null) {
            $this->status = $result;
            return $this->status;
        } else {
            return self::ACTION_WRONG;
        }
    }

    public function getActionMap()
    {
        return $this->actionMap;
        //исправил карту действий-теперь она возвращает список действий в виде простого массива
    }

    public function getStatusMap()
    {
        return $this->statusMap;
        //добавил метод,возвращающий просто массив статусов
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function actions()//метод который возвращает доступные действия
    {
        $result = [];
        switch ($this->status) {
            case "New":
                $result[] = self::ACTION_ABORT;
                $result[] = self::ACTION_RESPONSE;
                break;
            case "In work":
                $result[] = self::ACTION_FAILURE;
                $result[] = self::ACTION_COMPLETE;
                break;
            case "Failed":
                $result[] = self::ACTION_RESPONSE;
                break;
            case "Aborted":
                $result = null;
                break;
            case "Completed":
                $result = null;
                break;
        }
        return $result;
    }
}
