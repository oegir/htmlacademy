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

class CategoryController extends Controller
{
    public function actionIndex()
    {
        $cat = Category::find()->one();
        if ($cat) {
            var_dump($cat->name);
            $users = $cat->users;
            foreach ($users as $user) {
                print($user->name . \PHP_EOL);
            }
            $ucs = $cat->usersCategories;
            foreach ($ucs as $uc) {
                echo $uc->category->name . \PHP_EOL;
                echo $uc->user->name . \PHP_EOL;
            }
            return ExitCode::OK;
        }
        return ExitCode::DATAERR;
    }
}
