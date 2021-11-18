<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "locations".
 *
 * @property int $id
 * @property int $city_id
 * @property float|null $latitude широта места
 * @property float|null $longitude долгота места
 * @property string|null $district район
 * @property string|null $street улица
 * @property string|null $info дополн. информация
 */
class Location extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'locations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id'], 'required'],
            [['city_id'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['info'], 'string'],
            [['district', 'street'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'City ID',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'district' => 'District',
            'street' => 'Street',
            'info' => 'Info',
        ];
    }
}
