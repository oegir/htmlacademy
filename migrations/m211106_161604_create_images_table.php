<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%images}}`.
 */
class m211106_161604_create_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%images}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'img' => $this->string(256)->notNull(),
        ]);
        $this->addCommentOnTable('{{%images}}', 'Таблица фотографий работ исполнителя');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%images}}');
    }
}
