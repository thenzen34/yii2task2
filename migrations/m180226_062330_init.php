<?php

use yii\db\Migration;

/**
 * Class m180226_062330_init
 */
class m180226_062330_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //$this->execute('CREATE SCHEMA yii2task2');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180226_062330_init cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180226_062330_init cannot be reverted.\n";

        return false;
    }
    */
}
