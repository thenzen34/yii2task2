<?php

use yii\db\Migration;

/**
 * Handles the creation of table `calls`.
 * Has foreign keys to the tables:
 *
 * - `managers`
 */
class m180226_092801_create_calls_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('yii2task2.calls', [
            'id' => $this->primaryKey(),
            'manager_id' => $this->integer()->notNull(),
            'dt' => $this->timestamp()->notNull()->defaultValue(new \yii\db\Expression('now()')),
        ]);

        // creates index for column `manager_id`
        $this->createIndex(
            'idx-calls-manager_id',
            'yii2task2.calls',
            'manager_id'
        );

        // add foreign key for table `managers`
        $this->addForeignKey(
            'fk-calls-manager_id',
            'yii2task2.calls',
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
            'fk-calls-manager_id',
            'yii2task2.calls'
        );

        // drops index for column `manager_id`
        $this->dropIndex(
            'yii2task2.idx-calls-manager_id',
            'yii2task2.calls'
        );

        $this->dropTable('yii2task2.calls');
    }
}
