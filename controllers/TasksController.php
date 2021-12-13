<?php

namespace app\controllers;

use app\models\Task;
use app\models\Category;
use yii\web\Controller;
use app\models\Categories;
use yii\helpers\ArrayHelper;
use Yii;
use app\models\CategoryFilterForm;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $categories = new CategoryFilterForm();
        $categories->load(Yii::$app->request->post());
        $categories->validate();
        
        $query = Task::find()->select([
            'tasks.name',
            'tasks.budget',
            'cities.name as city',
            'locations.street as street',
            'categories.name as category',
            'add_date',
        ]);
        $query = $query->
            leftJoin('locations', 'loc_id = locations.id')->
            innerJoin('categories', 'cat_id = categories.id')->
            leftJoin('cities', 'cities.id = locations.city_id');
        $categories->applyCondition($query);
        $query = $query->limit($categories->limit)->offset($categories->offset)->orderBy(['add_date' => SORT_DESC]);
        $tasks = $query->all();

        $categores = Category::find()->select("*")->all();
        
        $categoryNames[Categories::MAIN_CATEGORIES] = ArrayHelper::map($categores, 'id', 'name');
        $categoryNames[Categories::ADD_CONDITION] = 'Без исполнителя';
        $categoryNames[Categories::PERIOD] = CategoryFilterForm::getAvailablePeriods();
        
        return $this->render('index', [
            'tasks' => $tasks,
            'categories' => $categories,
            'categoryNames' => $categoryNames,
        ]);
    }
}
