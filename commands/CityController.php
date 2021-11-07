<?php

/**
 * Проверка запросов к БД посредством моделей
 */

namespace app\commands;

use app\models\City;
use yii\console\Controller;
use yii\console\ExitCode;

class CityController extends Controller
{
    public function actionIndex()
    {
        $city = City::find()->one();
        if ($city) {
            var_dump($city->name);
            var_dump($city->latitude);
            var_dump($city->longitude);
            return ExitCode::OK;
        }
        return ExitCode::DATAERR;
    }
}
