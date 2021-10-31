<?php

namespace Anatolev\Service;

class ActCancel extends TaskAction
{
    private const NAME = 'Отменить';
    private const INNER_NAME = 'act_cancel';

    public static function getName(): string
    {
        return self::NAME;
    }

    public static function getInnerName(): string
    {
        return self::INNER_NAME;
    }

    public static function checkUserRights(int $executor_id, int $customer_id, int $user_id): bool
    {
        return $customer_id === $user_id;
    }
}
