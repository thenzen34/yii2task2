<?php

namespace app\models;

use app\models\query\BonusQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "yii2task2.bonus".
 *
 * @property int $id
 * @property string $name
 * @property int $salary
 * @property int $from
 * @property int $to
 */
class Bonus extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yii2task2.bonus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'from', 'to'], 'required'],
            [['salary', 'from', 'to'], 'default', 'value' => null],
            [['salary', 'from', 'to'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'salary' => 'Бонус',
            'from' => 'From',
            'to' => 'To',
        ];
    }

    /**
     * @inheritdoc
     * @return BonusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BonusQuery(get_called_class());
    }
}
