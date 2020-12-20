<?php

class Task
{

    const STATUS_NEW = 'new';
    const STATUS_IN_WORK = 'in_work';
    const STATUS_DONE = 'done';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCEL = 'cancel';

    const ACTION_CANCEL = 'cancel_task';
    const ACTION_ANSWER = 'answer';
    const ACTION_FINISHED = 'finished';
    const ACTION_DECLINE = 'decline';
    const ACTION_ACCEPT = 'accept';

    const ROLE_IMPLEMENT = 'implementer';
    const ROLE_CUSTOMER = 'customer';

    const STAUS_NAME  = [
        self::STATUS_NEW => 'Новое',
        self::STATUS_IN_WORK => 'В работе',
        self::STATUS_DONE => 'Выполнено',
        self::STATUS_FAILED => 'Провалено',
        self::STATUS_CANCEL => 'Отменено'
    ];

    const ACTION_NAME = [
        self::ACTION_CANCEL => 'Отменить',
        self::ACTION_ANSWER => 'Откликнуться',
        self::ACTION_FINISHED => 'Выполнено',
        self::ACTION_DECLINE => 'Отказаться',
        self::ACTION_ACCEPT => 'Принять'
    ];

    protected $nextActionAndNextStatus = [
        self::ACTION_CANCEL => self::STATUS_CANCEL,
        self::ACTION_ANSWER => null,
        self::ACTION_FINISHED => self::STATUS_DONE,
        self::ACTION_DECLINE => self::STATUS_FAILED,
        self::ACTION_ACCEPT => self::STATUS_IN_WORK,
        self::STATUS_NEW => [
            self::ROLE_IMPLEMENT => self::ACTION_ANSWER,
            self::ROLE_CUSTOMER => self::ACTION_CANCEL
        ],
        self::STATUS_IN_WORK => [
            self::ROLE_IMPLEMENT => self::ACTION_DECLINE,
            self::ROLE_CUSTOMER => self::ACTION_FINISHED
        ],
        self::STATUS_DONE => null,
        self::STATUS_FAILED => null,
        self::STATUS_CANCEL => null,
    ];
    public $user = '';

    protected $idTask = null;
    protected $idStatus = null;


    public function __construct(int $idTask, int $idStatus)
    {
        $this->idTask = $idTask;
        $this->idStatus = $idStatus;
    }

    public function getNextStatus(string $action)
    {
        if (!$action) {
            return null;
        }
        return $this->nextActionAndNextStatus[$action];
    }

    public function getNextAction(string $status)
    {
        if (!$status) {
            return null;
        }
        return $this->nextActionAndNextStatus[$status][$this->user];
    }
}
