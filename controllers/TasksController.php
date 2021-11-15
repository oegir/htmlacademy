<?php

namespace app\controllers;

use app\models\Task;
use app\models\Category;
use yii\web\Controller;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $tasks = Task::find()->select([
                'tasks.name',
                'tasks.budget',
                'cities.name as city',
                'locations.street as street',
                'categories.name as category',
                'add_date',
            ])->
            innerJoin('locations', 'loc_id = locations.id')->
            innerJoin('categories', 'cat_id = categories.id')->
            innerJoin('cities', 'cities.id = locations.city_id')->
            limit(3)->offset(0)->orderBy(['add_date' => SORT_DESC])->all();
        $cats = Category::find()->select("*")->all();
        return $this->render('index', [
            'tasks' => $tasks,
            'cats' => $cats,
        ]);
    }
}
