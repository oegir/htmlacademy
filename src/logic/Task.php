<?php

namespace TaskForce\logic;

/**
 * Task - класс описания задания и работы с ним
 */
class Task
{
    public const STATUS_NEW = 'new';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_WORK = 'work';
    public const STATUS_DONE = 'done';
    public const STATUS_FAILED = 'failed';

    public const ACTION_START = 'start';
    public const ACTION_COMPLETE = 'complete';
    public const ACTION_REFUSE = 'refuse';
    public const ACTION_CANCEL = 'cancel';

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
    public function __construct(int $customerId, int $contractorId)
    {
        $this->customer = $customerId;
        $this->contractor = $contractorId;
        $this->status = self::STATUS_NEW;
    }

    /**
     * Возаращает карту статусов
     */
    public function getStatusMap(): array
    {
        return $this->statusMap;
    }

    /**
     * Возвращает карту действий
     */
    public function getACtionMap(): array
    {
        return $this->actionMap;
    }

    /**
     * Возвращает значение статуса, в которой перейдёт заданме
     * после выполнения указанного действия
     * @param string $action - требуемое действие
     *
     * @return string - значение статуса, соответсвующего действию
     * или null, если такого статуса нет
     */
    public function mapActionToStatus(string $action): ?string
    {
        return $this->actionStatusMap[$action] ?? null;
    }

    /**
     * Возвращает массив доступных действий, соответствующий заданному статусу задания
     * @param string $status - заданный статус
     *
     * @return array - массив доступных действий
     * или пустой массив, если доступных действий нет
     */
    public function mapStatusToAllowedActions($status): array
    {
        return $this->allowedActions[$status] ?? [];
    }
}
