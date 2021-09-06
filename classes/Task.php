<?php

class Task
{
    public const STATUS_NEW = 'new';
    public const STATUS_CANCEL = 'cancel';
    public const STATUS_WORK = 'work';
    public const STATUS_DONE = 'done';
    public const STATUS_FAILED = 'failed';

    public const ACTION_CANCEL = 'action_cancel';
    public const ACTION_RESPOND = 'action_respond';
    public const ACTION_DONE = 'action_done';
    public const ACTION_REFUSE = 'action_refuse';

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
            self::ACTION_CANCEL => 'Отменить',
            self::ACTION_RESPOND => 'Откликнуться',
            self::ACTION_DONE => 'Выполнено',
            self::ACTION_REFUSE => 'Отказаться'
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
            self::ACTION_CANCEL => self::STATUS_CANCEL,
            self::ACTION_RESPOND => self::STATUS_WORK,
            self::ACTION_DONE => self::STATUS_DONE,
            self::ACTION_REFUSE => self::STATUS_FAILED
        ];

        return $data[$action] ?? '';
    }

    /**
     * Возвращает массив доступных действий для указанного статуса
     * @param string $status Статус задания
     * @return array
     */
    public function getAvailableActions(string $status): array
    {
        $data = [
            self::STATUS_NEW => [
                self::ACTION_CANCEL,
                self::ACTION_RESPOND
            ],
            self::STATUS_WORK => [
                self::ACTION_DONE,
                self::ACTION_REFUSE
            ]
        ];

        return $data[$status] ?? [];
    }
}
