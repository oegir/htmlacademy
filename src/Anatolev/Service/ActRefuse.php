<?php

namespace Anatolev\Service;

class ActRefuse extends TaskAction
{
    private const NAME = 'Отказаться';
    private const INNER_NAME = 'act_refuse';

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
        return $executor_id === $user_id;
    }
}
