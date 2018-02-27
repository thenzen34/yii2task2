<?php

use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m180227_051712_add_dt_index_to_calls_table
 */
class m180227_051712_add_dt_index_to_calls_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-calls-dt_date',
            'yii2task2.calls',
            new Expression('("dt"::date)')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops index for column `manager_id`
        $this->dropIndex(
            'yii2task2.idx-calls-dt_date',
            'yii2task2.calls'
        );
    }
}
