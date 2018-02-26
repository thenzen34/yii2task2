<?php

use yii\db\Migration;

/**
 * Handles the creation of table `calls_by_day`.
 * Has foreign keys to the tables:
 *
 * - `managers`
 */
class m180226_093707_create_calls_by_day_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('yii2task2.calls_by_day', [
            'id' => $this->primaryKey(),
            'manager_id' => $this->integer()->notNull(),
            'date' => $this->date()->notNull(),
            'calls' => $this->integer(),
        ]);

        // creates index for column `manager_id`
        $this->createIndex(
            'idx-calls_by_day-manager_id',
            'yii2task2.calls_by_day',
            'manager_id'
        );

        // add foreign key for table `managers`
        $this->addForeignKey(
            'fk-calls_by_day-manager_id',
            'yii2task2.calls_by_day',
            'manager_id',
            'yii2task2.managers',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `managers`
        $this->dropForeignKey(
            'fk-calls_by_day-manager_id',
            'yii2task2.calls_by_day'
        );

        // drops index for column `manager_id`
        $this->dropIndex(
            'yii2task2.idx-calls_by_day-manager_id',
            'yii2task2.calls_by_day'
        );

        $this->dropTable('yii2task2.calls_by_day');
    }
}
