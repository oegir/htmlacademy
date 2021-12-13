<?php
namespace app\models;

use yii\base\Model;
use TaskForce\validator\Period;
use yii\db\Query;
use yii\db\conditions\InCondition;
use yii\db\conditions\SimpleCondition;

class CategoryFilterForm extends Model
{
    public const NO_ADDITION_SELECTED = '888';
    
    /**
     * elected other than categories in the form
     * @var int
     */
    public $additionCategoryCheck = self::NO_ADDITION_SELECTED;
    
    /**
     * Checked categories
     * @var array
     */
    public $categoriesCheckArray = [];
    
    /**
     * @var integer
     */
    public $limit = 3;
    
    /**
     * @var integer
     */
    public $offset = 0;
    
    /**
     * @var null|integer
     */
    public $period = null;
    
    /**
     * Available time periods
     * @var array
     */
    private static $hours = [
        '1 час' => 1,
        '12 часов' => 12,
        '24 часа' => 24
    ];
    
    /**
     * Get available periods strings
     * @return array
     */
    public static function getAvailablePeriods(): array
    {
        return array_keys(self::$hours);
    }
    
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
            ['categoriesCheckArray', 'default', 'value' => []],
            ['categoriesCheckArray', 'each', 'rule' => ['integer']],
            ['additionCategoryCheck', 'safe'],
            ['period', Period::class],
            ['limit', 'integer', 'min' => 1],
            ['limit', 'default', 'value' => 3],
            ['offset', 'integer', 'min' => 0],
            ['limit', 'default', 'value' => 0],
        ];
    }
    
    public function applyCondition(Query $query)
    {
        $query = $query->andWhere(['tasks.status' => \TaskForce\logic\Task::STATUS_NEW]);
        
        if (! $this->hasErrors()) {
            $hours = $this->getAvailableHours();
            $date = date("Y-m-d H:i:s", time() - 3600 * $hours[$this->period]);
            $query = $query->andWhere(new SimpleCondition('add_date', '>', $date));
        }
        
        if ($this->additionCategoryCheck !== self::NO_ADDITION_SELECTED) {
            $query = $query->andWhere(['contr_id' => 0]);
        }
        
        if (! empty($this->categoriesCheckArray)) {
            $query = $query->andWhere(new InCondition('cat_id', 'in', $this->categoriesCheckArray));
        }
    }
    
    /**
     * Get available periods hours numbers
     * @return array
     */
    private function getAvailableHours(): array
    {
        return array_values(self::$hours);
    }
}

