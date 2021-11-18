<?php

namespace app\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%documents}}`.
 */
class m211106_161535_create_documents_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%documents}}', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer()->notNull(),
            'link' => $this->string(512)->notNull(),
        ])->comment('Таблица ссылок на дополнительные документы к заданию');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%documents}}');
    }
}
