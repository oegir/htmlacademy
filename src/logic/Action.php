<?php

namespace TaskForce\logic;

/**
 * Абстрактный класс для описания действия
 */
abstract class Action
{
    /**
     * Метод проверки прав юзера на применение данного действия
     *
     * @param int $customerId   - id заказчика задания
     * @param int $contractorId - id исполнителя задания
     * @param int $userId       - id пользователя задания
     *
     * @return bool true, если действие пользователю разрешено, false в противном случае
     */
    abstract public function checkActionRights(int $customerId, int $contractorId, int $userId): bool;
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
