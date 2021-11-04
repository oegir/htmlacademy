<?php

/**
 * Проверка запросов к БД посредством моделей
 */

namespace app\commands;

use app\models\User;
use app\models\Category;
use app\models\UsersCategories;
use yii\console\Controller;
use yii\console\ExitCode;

class UserController extends Controller
{
    public function actionIndex()
    {
        $userId = 1;
        $user = User::findOne($userId);
        if ($user) {
            var_dump($user->name);
            var_dump($user->email);
            $categories = $user->categories;
            foreach ($categories as $cat) {
                print($cat->name . \PHP_EOL);
            }
            $ucs = $cat->usersCategories;
            foreach ($ucs as $uc) {
                echo $uc->user->name . \PHP_EOL;
                echo $uc->category->name . \PHP_EOL;
            }
            return ExitCode::OK;
        }
        return ExitCode::DATAERR;
    }
}
