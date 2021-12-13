<?php
namespace TaskForce\validator;

use yii\validators\Validator;
use app\models\CategoryFilterForm;

class Period extends Validator
{
    /**
     * {@inheritDoc}
     * @see \yii\validators\Validator::validateAttribute()
     */
    public function validateAttribute($model, $attribute) {
        $periodKeys = array_keys(CategoryFilterForm::getAvailablePeriods());
        /*
         * Thanks De Morgan
         * @see https://ru.wikipedia.org/wiki/Законы_де_Моргана
         */
        if (!(empty($model->$attribute) || isset($periodKeys[$model->$attribute]))) {
            $this->addError($model, $attribute, 'Period has be one of these values: ', implode(', ', $periodKeys));
        }
    }
}

