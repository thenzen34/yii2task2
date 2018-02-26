<?php

use yii\db\Migration;

/**
 * Handles the creation of table `calls_by_month`.
 * Has foreign keys to the tables:
 *
 * - `managers`
 * - `bonus`
 */
class m180226_094205_create_calls_by_month_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('yii2task2.calls_by_month', [
            'id' => $this->primaryKey(),
            'manager_id' => $this->integer()->notNull(),
            'date' => $this->date()->notNull(),
            'calls' => $this->integer(),
            'bonus_id' => $this->integer(),
        ]);

        // creates index for column `manager_id`
        $this->createIndex(
            'idx-calls_by_month-manager_id',
            'yii2task2.calls_by_month',
            'manager_id'
        );

        // add foreign key for table `managers`
        $this->addForeignKey(
            'fk-calls_by_month-manager_id',
            'yii2task2.calls_by_month',
            'manager_id',
            'yii2task2.managers',
            'id',
            'CASCADE'
        );

        // creates index for column `bonus_id`
        $this->createIndex(
            'idx-calls_by_month-bonus_id',
            'yii2task2.calls_by_month',
            'bonus_id'
        );

        // add foreign key for table `bonus`
        $this->addForeignKey(
            'fk-calls_by_month-bonus_id',
            'yii2task2.calls_by_month',
            'bonus_id',
            'yii2task2.bonus',
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
            'fk-calls_by_month-manager_id',
            'yii2task2.calls_by_month'
        );

        // drops index for column `manager_id`
        $this->dropIndex(
            'yii2task2.idx-calls_by_month-manager_id',
            'yii2task2.calls_by_month'
        );

        // drops foreign key for table `bonus`
        $this->dropForeignKey(
            'fk-calls_by_month-bonus_id',
            'yii2task2.calls_by_month'
        );

        // drops index for column `bonus_id`
        $this->dropIndex(
            'yii2task2.idx-calls_by_month-bonus_id',
            'yii2task2.calls_by_month'
        );

        $this->dropTable('yii2task2.calls_by_month');
    }
}
