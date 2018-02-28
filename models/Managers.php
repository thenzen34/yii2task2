<?php

namespace app\models;

use app\models\query\ManagersQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "yii2task2.managers".
 *
 * @property int $id
 * @property string $name
 * @property int $salary
 *
 * @property CallsByDay[] $callsByDay
 * @property CallsByMonth $lastMonth
 */
class Managers extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yii2task2.managers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['salary'], 'default', 'value' => 0],
            [['salary'], 'integer'],
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
            'name' => 'Менеджер',
            'salary' => 'Оклад',
        ];
    }

    /**
     * @inheritdoc
     * @return ManagersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ManagersQuery(get_called_class());
    }

    public function getStatByDay()
    {
        return $this->hasMany(CallsByDay::class, ['manager_id' => 'id'])
            ->andWhere(['>=', 'date', new Expression("now()-'1 month'::interval")]);
    }

    public function getLastMonth()
    {
        return $this->hasOne(CallsByMonth::class, ['manager_id' => 'id'])
            ->andWhere(['>=', 'date', new Expression("now()-'1 month'::interval")]);
    }

    /**
     * @return int[]
     */
    public static function getAllIds()
    {
        return self::find()
            ->select(['id'])
            ->column();
    }
}
