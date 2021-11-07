<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property string $content
 * @property int $from_id от кого сообщение
 * @property int $whom_id кому сообщение
 * @property string $add_date
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'from_id', 'whom_id', 'add_date'], 'required'],
            [['from_id', 'whom_id'], 'integer'],
            [['add_date'], 'safe'],
            [['content'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'from_id' => 'From ID',
            'whom_id' => 'Whom ID',
            'add_date' => 'Add Date',
        ];
    }
}
