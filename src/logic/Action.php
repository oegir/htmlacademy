<?php

namespace TaskForce\logic;

/**
 * Абстрактный класс для описания действия
 */
abstract class Action
{
    protected const ACTION_START = 'start';
    protected const ACTION_COMPLETE = 'complete';
    protected const ACTION_REFUSE = 'refuse';
    protected const ACTION_CANCEL = 'cancel';

    protected static $actionMap = [
        self::ACTION_START => 'стартовать задание',
        self::ACTION_COMPLETE => 'завершить задание',
        self::ACTION_REFUSE => 'отказаться от задания',
        self::ACTION_CANCEL => 'отменить задание'
    ];

    /**
     * Метод проверки прав юзера на применение данного действия
     *
     * @param int $customerId   - id заказчика задания
     * @param int $contractorId - id исполнителя задания
     * @param int $userId       - id пользователя задания
     *
     * @return bool true, если действие пользователю разрешено, false в противном случае
     */
    abstract public function checkActionRights(int $customerId, int $contractorId, int $userId);
    /**
     * Метод возвращает название действия
     *
     * @return string
     */
    abstract public function getTitle(): string;
    /**
     * Метод возвращает имя действия
     *
     * @return string
     */
    abstract public function getName(): string;
}
