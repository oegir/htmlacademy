<?php

class Task
{
    const STATUS_NEW = 'Новое';
    const STATUS_WORK = 'В работе';
    const ACTION_WORK = 'В работать';
    const STATUS_COMPLETE = 'Выполнено';
    const ACTION_COMPLETE = 'Выполнить';
    const STATUS_FAILED = 'Провалено';
    const ACTION_FAILED = 'Провалить';
    const STATUS_CANCEL = 'Отменено';
    const ACTION_CANCEL = 'Отменить';

    private $status = self::STATUS_NEW;
    private $workerId;
    private $ownerId;

    public function __construct($workerId, $ownerId)
    {
        $this->workerId = $workerId;
        $this->ownerId = $ownerId;
    }

    public function setWorkTask($userId)
    {
        if ($userId == $this->workerId) {
            $this->status = self::STATUS_WORK;
        }
        return $this->status;
    }

    public function setCompleteTask($userId)
    {
        if ($userId == $this->ownerId && $this->status == self::STATUS_WORK) {
            $this->status = self::STATUS_COMPLETE;
        }
        return $this->status;
    }

    public function setFailedTask($userId)
    {
        if ($userId == $this->workerId && $this->status == self::STATUS_WORK) {
            $this->status = self::STATUS_FAILED;
        }
        return $this->status;
    }

    public function setCancelTask($userId)
    {
        if ($userId == $this->ownerId) {
            $this->status = self::STATUS_CANCEL;
        }
        return $this->status;
    }

    public function getNextStatus($action, $userId)
    {
        switch ($action) {
            case self::ACTION_WORK:
                return $this->setWorkTask($userId);
                break;
            case self::ACTION_COMPLETE:
                return $this->setCompleteTask($userId);
                break;
            case self::ACTION_FAILED:
                return $this->setFailedTask($userId);
                break;
            case self::ACTION_CANCEL:
                return $this->setCancelTask($userId);
                break;
            default :
                return $this->status;
        }
    }
}
