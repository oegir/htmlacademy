<?php

use yii\db\Migration;

/**
 * Class m211210_073822_tasks_default_values
 */
class m211210_073822_tasks_default_values extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('tasks', 'contr_id', "INT DEFAULT 0 COMMENT 'исполнитель'");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211210_073822_tasks_default_values cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211210_073822_tasks_default_values cannot be reverted.\n";

        return false;
    }
    */
}
