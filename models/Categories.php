<?php

namespace app\models;

use yii\base\Model;

class Categories extends Model
{
    public const MAIN_CATEGORIES = 'main_categories';
    public const ADD_CONDITION = 'add_condition';
    public const PERIOD = 'period';

    protected $period = '';

    public function rules()
    {
        return [
            ['categoriesCheckArray', 'safe'],
            ['additionCategoryCheck', 'safe'],
            ['period', 'safe'],
        ];
    }

    public function getCategoriesCheckArray()
    {
        return $this->categoriesCheckArray;
    }

    public function setCategoriesCheckArray($categories)
    {
        $this->categoriesCheckArray = $categories;
    }

    public function getAdditionCategoryCheck()
    {
        return $this->additionCategoryCheck;
    }

    public function setAdditionCategoryCheck($check)
    {
        $this->additionCategoryCheck = $check;
    }

    public function getPeriod()
    {
        return $this->period;
    }

    public function setPeriod($period)
    {
        $this->period = $period;
    }
}
