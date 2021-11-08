<?php

namespace Anatolev\Service;

abstract class TaskAction
{
    /**
     * Возвращает название действия
     * @return string
     */
    abstract protected static function getName(): string;

    /**
     * Возвращает внутреннее имя действия
     * @return string
     */
    abstract protected static function getInnerName(): string;

    /**
     * Проверяет права пользователя
     * Возвращает true или false
     * (в зависимости от доступности выполнения этого действия)
     * @return bool
     */
    abstract protected static function checkUserRights(int $executor_id, int $customer_id, int $user_id): bool;
}
