<?php
namespace TaskForce\logic;

/**
 * Task - класс описания задания и работы с ним
 */
class Task
{
    private const STATUS_NEW = 'new';
    private const STATUS_CANCELED = 'canceled';
    private const STATUS_WORK = 'work';
    private const STATUS_DONE = 'done';
    private const STATUS_FAILED = 'failed';
    
    private const ACTION_START = 'start';
    private const ACTION_COMPLETE = 'complete';
    private const ACTION_REFUSE = 'refuse';
    private const ACTION_CANCEL = 'cancel';

    private $statusMap = [
        self::STATUS_NEW => 'новое задание',
        self::STATUS_CANCELED => 'задание отменено',
        self::STATUS_DONE => 'задание завершено',
        self::STATUS_FAILED => 'задание провалено',
        self::STATUS_WORK => 'задание в работе'
    ];

    private $actionMap = [
        self::ACTION_START => 'стартовать задание',
        self::ACTION_COMPLETE => 'завершить задание',
        self::ACTION_REFUSE => 'отказаться от задания',
        self::ACTION_CANCEL => 'отменить задание'
    ];

    private $actionStatusMap = [
        self::ACTION_START => self::STATUS_WORK,
        self::ACTION_COMPLETE => self::STATUS_DONE,
        self::ACTION_REFUSE => self::STATUS_FAILED,
        self::ACTION_CANCEL => self::STATUS_CANCELED
    ];

    private $allowedActions = [
        self::STATUS_NEW => [self::ACTION_START, self::ACTION_CANCEL],
        self::STATUS_WORK => [self::ACTION_COMPLETE, self::ACTION_REFUSE],
        self::STATUS_CANCELED => [],
        self::STATUS_DONE => [],
        self::STATUS_FAILED => []
    ];

    //id заказчика
    private $customer;
    //id исполнителя
    private $contractor;
    //текущий статус состояния задания
    private $status;

    /**
     * Конструктор класса
     * @param int $customerId - id заказчика задания
     * @param int $contractorId - id исполнителя задания
     */
    public function __construct(int $customerId, int $contractorId) {
        $this->customer = $customerId;
        $this->contractor = $contractorId;
        $this->status = self::STATUS_NEW;
        echo 'construct() новое задание', \PHP_EOL;
        echo $this->status, \PHP_EOL;
    }

    /**
     * Возаращает карту статусов
     */
    public function getStatusMap() : array {
        return $this->statusMap;
    }

    /**
     * Возвращает карту действий
     */
    public function getACtionMap() : array {
        return $this->actionMap;
    }

    /**
     * Возвращает значение статуса, в которой перейдёт заданме
     * после выполнения указанного действия
     * @param string $action - требуемое действие
     * 
     * @return string - значение статуса, соответсвующего действию
     * или пустая строка, если такого статуса нет
     */
    public function mapActionToStatus(string $action) : string {
        foreach($this->actionStatusMap as $key => $value) {
            if ($key === $action) {
                return $value;
            }
        }
        return '';
    }

    /**
     * Возвращает массив доступных действий, соответствующий заданному статусу задания
     * @param string $status - заданный статус
     * 
     * @return array - массив доступных действий
     * или пустой массив, если доступных действий нет
     */
    public function mapStatusToAllowedActions($status) : array {
        foreach($this->allowedActions as $key => $value) {
            if ($key === $status) {
                return $value;
            }
        }
        return [];
    }
}
