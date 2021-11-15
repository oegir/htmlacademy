<?php

namespace app\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%categories}}`.
 */
class m211106_150554_create_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%categories}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull(),
            'code' => $this->string(64)->notNull()->unique(),
            'icon' => $this->string(256)->null(),
        ])->comment('Таблица категорий');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%categories}}');
    }
}
