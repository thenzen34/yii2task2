<?php

use yii\db\Migration;

/**
 * Handles the creation of table `managers`.
 */
class m180226_063142_create_managers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('yii2task2.managers', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'salary' => $this->integer()->notNull()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('yii2task2.managers');
    }
}
