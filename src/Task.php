<?php
namespace Taskforce;

class Task {
    public const STATUS_NEW = 'new';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_IN_WORK = 'in_work';
    public const STATUS_PERFORMED = 'performed';
    public const STATUS_FAILED = 'failed';
    public const STATUS_COMPLETED = 'completed';

    public const ACTION_CANCEL = 'cancel';
    public const ACTION_RESPOND = 'respond';
    public const ACTION_APPROVE = 'approve';
    public const ACTION_REFUSE = 'refuse';
    public const ACTION_COMPLETE = 'complete';

    public const CUSTOMER_ROLE = 'customer';
    public const EXECUTOR_ROLE = 'executor';

    private $current_status = self::STATUS_NEW;
    private int $executor_id;
    private int $customer_id;

    public static $status_map = [
        self::STATUS_NEW => 'Новое',
        self::STATUS_CANCELED => 'Завершено',
        self::STATUS_IN_WORK => 'В работе',
        self::STATUS_PERFORMED => 'Выполнено',
        self::STATUS_FAILED => 'Провалено',
        self::STATUS_COMPLETED => 'Выполнено'
    ];

    public static $action_map = [
        self::ACTION_CANCEL => 'Завершить',
        self::ACTION_RESPOND => 'Откликнуться',
        self::ACTION_APPROVE => 'Утвердить',
        self::ACTION_REFUSE => 'Отказаться',
        self::ACTION_COMPLETE => 'Завершить'
    ];

public static $status_action_map = [
        self::STATUS_NEW => [
            self::CUSTOMER_ROLE => [
                self::ACTION_CANCEL => self::STATUS_CANCELED,
                self::ACTION_APPROVE => self::STATUS_IN_WORK
            ]
        ],
        self::STATUS_IN_WORK => [
            self::EXECUTOR_ROLE => [
                self::ACTION_REFUSE => self::STATUS_FAILED
            ],
            self::CUSTOMER_ROLE => [
                self::ACTION_COMPLETE => self::STATUS_COMPLETED
            ]
        ],
    ];

    public static $role_map = [
        self::CUSTOMER_ROLE => 'Заказчик',
        self::EXECUTOR_ROLE => 'Исполнитель'
    ];

    public function __construct(int $customer_id, int $executor_id = 0) {
        $this->executor_id = $executor_id;
        $this->customer_id = $customer_id;
    }

    public function getCurrentStatus(): string {
        return $this->current_status;
    }

    public static function getStatusMap(string $status): ?array {
        if(isset(self::$status_map[$status])) {
            return self::$status_action_map[$status];
        }
    }

private function getAvailableActions(string $status, string $role): array
{
        $actionsArray = self::$status_action_map[$status][$role] ?? [];
        $result = array_keys($actionsArray);
        return $result;
}


    public function getAvailableExecutorActions(string $status): ?array {
        if(isset(self::$status_map[$status])) {
            return $this->getAvailableActions($status, self::EXECUTOR_ROLE);
        }
    }

    public function getAvailableCustomerActions(string $status): ?array {
        if(isset(self::$status_map[$status])) {
            return $this->getAvailableActions($status, self::CUSTOMER_ROLE);
        }
    }

    public function getNextStatus(string $action, string $role): string {
        if(isset(self::$action_map[$action]) && isset(self::$role_map[$role])) {
            return self::$status_action_map[$this->current_status][$role][$action] ?? '';
        }
    }

    public function setStatus(string $newStatus): bool {
        if(isset(self::$status_map[$newStatus])) {
            $this->current_status = $newStatus;
            return true;
        }
        return false;
    }
}