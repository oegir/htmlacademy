<?php

namespace Anatolev\Service;

class Task
{
    public const STATUS_NEW = 'new';
    public const STATUS_CANCEL = 'cancel';
    public const STATUS_WORK = 'work';
    public const STATUS_DONE = 'done';
    public const STATUS_FAILED = 'failed';

    public string $current_status = self::STATUS_NEW;

    public function __construct(
        public int $executor_id,
        public int $customer_id
    ) {}

    /**
     * Возвращает "карту" статусов
     * [внутреннее имя => название статуса на русском]
     * @return array
     */
    public function getStatusMap(): array
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCEL => 'Отменено',
            self::STATUS_WORK => 'В работе',
            self::STATUS_DONE => 'Выполнено',
            self::STATUS_FAILED => 'Провалено'
        ];
    }

    /**
     * Возвращает "карту" действий
     * [внутреннее имя => название действия на русском]
     * @return array
     */
    public function getActionMap(): array
    {
        return [
            ActCancel::getInnerName() => ActCancel::getName(),
            ActRespond::getInnerName() => ActRespond::getName(),
            ActDone::getInnerName() => ActDone::getName(),
            ActRefuse::getInnerName() => ActRefuse::getName()
        ];
    }

    /**
     * Возвращает статус, в который перейдёт задание
     * после выполнения указанного действия
     * @param string $action Действие
     * @return string
     */
    public function getNextStatus(string $action): string
    {
        $data = [
            ActCancel::getInnerName() => self::STATUS_CANCEL,
            ActRespond::getInnerName() => self::STATUS_WORK,
            ActDone::getInnerName() => self::STATUS_DONE,
            ActRefuse::getInnerName() => self::STATUS_FAILED
        ];

        return $data[$action] ?? '';
    }

    /**
     * Возвращает объект доступного действия
     * для указанного статуса и пользователя
     * @param string $status Статус задания
     * @param int $user_id Идентификатор пользователя
     *
     * @return object|null
     */
    public function getAvailableAction(string $status, int $user_id): ?object
    {
        $ids = [$this->executor_id, $this->customer_id, $user_id];

        if (
            $status === self::STATUS_NEW
            && ActCancel::checkUserRights(...$ids)
        ) {
            $action = new ActCancel();

        } elseif (
            $status === self::STATUS_NEW
            && ActRespond::checkUserRights(...$ids)
        ) {
            $action = new ActRespond();

        } elseif (
            $status === self::STATUS_WORK
            && ActDone::checkUserRights(...$ids)
        ) {
            $action = new ActDone();

        } elseif (
            $status === self::STATUS_WORK
            && ActRefuse::checkUserRights(...$ids)
        ) {
            $action = new ActRefuse();
        }

        return $action ?? null;
    }
}
