<?php

namespace app\models;

use yii\base\Model;

class Categories extends Model
{
    public const MAIN_CATEGORIES = 'main_categories';
    public const ADD_CONDITION = 'add_condition';
    public const PERIOD = 'period';
    public const CATEGORIES_NOT_SELECTED = '999';
    public const NO_ADDITION_SELECTED = '888';

    protected $categoriesCheckArray = self::CATEGORIES_NOT_SELECTED;
    protected $additionCategoryCheck = self::NO_ADDITION_SELECTED;
    protected $period = '';

    public function attributeLabels()
    {
        return [
            'categoriesCheckArray' => 'Категории',
            'additionCategoryCheck' => 'Дополнительно',
            'period' => 'Период',
        ];
    }

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
