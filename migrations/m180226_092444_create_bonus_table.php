<?php

use yii\db\Migration;

/**
 * Handles the creation of table `bonus`.
 */
class m180226_092444_create_bonus_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('yii2task2.bonus', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'salary' => $this->integer()->notNull()->defaultValue(0),
            'from' => $this->integer()->notNull(),
            'to' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('yii2task2.bonus');
    }
}
