<?php

class Task
{

    const STATUS_NEW = 'new';
    const STATUS_IN_WORK= 'in_work';
    const STATUS_DONE = 'done';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCEL = 'cancel';

    const ACTION_CANCEL = 'cancel_task';
    const ACTION_ANSWER = 'answer';
    const ACTION_FINISHED = 'finished';
    const ACTION_DECLINE = 'decline';
    const ACTION_ACCEPT = 'accept';

    protected $arrayMapActionAndStatus = [
        self::STATUS_NEW => 'Новое',
        self::STATUS_IN_WORK => 'В работе',
        self::STATUS_DONE => 'Выполнено',
        self::STATUS_FAILED => 'Провалено',
        self::STATUS_CANCEL => 'Отменено',
        self::ACTION_CANCEL => 'Отменить',
        self::ACTION_ANSWER => 'Откликнуться',
        self::ACTION_FINISHED => 'Выполнено',
        self::ACTION_DECLINE => 'Отказаться',
        self::ACTION_ACCEPT => 'Принять'
    ];
    protected $arrayNextActionAndNextStatus = [
        self::ACTION_CANCEL => self::STATUS_CANCEL,
        self::ACTION_ANSWER => null,
        self::ACTION_FINISHED => self::STATUS_DONE,
        self::ACTION_DECLINE => self::STATUS_FAILED,
        self::ACTION_ACCEPT => self::STATUS_IN_WORK,
        self::STATUS_NEW => [
            'implementer' => self::ACTION_ANSWER,
            'customer' => self::ACTION_CANCEL
        ],
        self::STATUS_IN_WORK => [
            'implementer' => self::ACTION_DECLINE,
            'customer' => self::ACTION_FINISHED
        ],
        self::STATUS_DONE => null,
        self::STATUS_FAILED => null,
        self::STATUS_CANCEL => null,
    ];
    public $strUser = '';

    protected $intIdTask = null;
    protected $intIdStatus = null;

    public function __construct(int $intIdTask,int $intIdStatus)
    {
        $this->intIdTask = $intIdTask;
        $this->intIdStatus = $intIdStatus;
    }


    public function getNextStatus(string $action)
    {
        if(strlen($action) < 1){
            return null;
        }
        return $this->arrayNextActionAndNextStatus[$action];
    }

    public function getNextAction(string $status)
    {
        if(strlen($status) < 1){
            return null;
        }
        return $this->arrayNextActionAndNextStatus[$status][$this->strUser];
    }
}
