<?php

namespace TaskForce\logic;

use TaskForce\logic\ActionStart;
use TaskForce\logic\ActionComplete;
use TaskForce\logic\ActionCancel;
use TaskForce\logic\ActionRefuse;
use TaskForce\exception\TaskForceException;
use TaskForce\exception\TaskForceActionException;

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

    public $actStart;
    public $actCancel;
    public $actComplete;
    public $actRefuse;

    private $statusMap;
    private $actionMap;
    private $actionStatusMap;
    private $allowedActions;

    //id заказчика
    private $customer;
    //id исполнителя
    private $contractor;
    //id юзера
    private $user;
    //текущий статус состояния задания
    private $status;

    /**
     * Конструктор класса
     *
     * @param int $customerId   - id заказчика задания
     * @param int $contractorId - id исполнителя задания
     */
    public function __construct(int $customerId, int $contractorId)
    {
        $this->customer = $customerId;
        $this->contractor = $contractorId;
        $this->status = self::STATUS_NEW;

        $this->actStart = new ActionStart();
        $this->actCancel = new ActionCancel();
        $this->actComplete = new ActionComplete();
        $this->actRefuse = new ActionRefuse();

        $this->actionMap = [
            $this->actStart->getName() => $this->actStart->getTitle(),
            $this->actComplete->getName() => $this->actComplete->getTitle(),
            $this->actRefuse->getName() => $this->actRefuse->getTitle(),
            $this->actCancel->getName() => $this->actCancel->getTitle()
        ];
        $this->statusMap = [
            self::STATUS_NEW => 'новое задание',
            self::STATUS_CANCELED => 'задание отменено',
            self::STATUS_DONE => 'задание завершено',
            self::STATUS_FAILED => 'задание провалено',
            self::STATUS_WORK => 'задание в работе'
        ];
        $this->actionStatusMap = [
            $this->actStart->getName() => self::STATUS_WORK,
            $this->actComplete->getName() => self::STATUS_DONE,
            $this->actRefuse->getName() => self::STATUS_FAILED,
            $this->actCancel->getName() => self::STATUS_CANCELED
        ];
        $this->allowedActions = [
            self::STATUS_NEW => [$this->actStart, $this->actCancel],
            self::STATUS_WORK => [$this->actComplete, $this->actRefuse],
            self::STATUS_CANCELED => [],
            self::STATUS_DONE => [],
            self::STATUS_FAILED => []
        ];
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
     *
     * @param string $action - требуемое действие
     *
     * @return string - значение статуса, соответсвующего действию
     * или null, если такого статуса нет
     * @throw TaskForceActionException, если такого статуса нет
     */
    public function mapActionToStatus(Action $action): ?string
    {
        if (!array_key_exists($action->getName(), $this->actionStatusMap)) {
            throw new TaskForceActionException('mapActionToStatus: недопустимое действие ' . $action->getName());
        }
        return $this->actionStatusMap[$action->getName()] ?? null;
    }

    /**
     * Возвращает массив доступных действий, соответствующий заданному статусу задания
     *
     * @param string $status - заданный статус
     * @param int    $userId - id пользователя (заказчика или исполнителя)
     *
     * @return array - массив доступных действий
     * или пустой массив, если доступных действий нет
     * @throw TaskForceException, если задан недопустимый статус
     */
    public function mapStatusToAllowedActions(string $status, int $userId): array
    {
        if (!array_key_exists($status, $this->statusMap)) {
            throw new TaskForceException('mapStatusToAllowedActions: недопустимый статус ' . $status);
        }
        $this->user = $userId;
        return array_values(array_filter($this->allowedActions[$status] ?? [], function ($action) {
            return $action->checkActionRights($this->customer, $this->contractor, $this->user);
        }));
    }
}
