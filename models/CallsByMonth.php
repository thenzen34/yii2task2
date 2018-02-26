<?php

namespace app\models;

use app\models\query\CallsByMonthQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "yii2task2.calls_by_month".
 *
 * @property int $id
 * @property int $manager_id
 * @property string $date
 * @property int $calls
 * @property int $bonus_id
 *
 * @property Managers $managers
 * @property Bonus $bonus
 */
class CallsByMonth extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yii2task2.calls_by_month';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['manager_id', 'date'], 'required'],
            [['manager_id', 'calls', 'bonus_id'], 'default', 'value' => null],
            [['manager_id', 'calls', 'bonus_id'], 'integer'],
            [['date'], 'safe'],
            [['bonus_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bonus::class, 'targetAttribute' => ['bonus_id' => 'id']],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => Managers::class, 'targetAttribute' => ['manager_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'manager_id' => 'Manager ID',
            'date' => 'Date',
            'calls' => 'Calls',
            'bonus_id' => 'Bonus ID',
        ];
    }

    /**
     * @inheritdoc
     * @return CallsByMonthQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CallsByMonthQuery(get_called_class());
    }

    public function getManagers()
    {
        return $this->hasOne(Managers::class, ['id' => 'type']);
    }

    public function getBonus()
    {
        return $this->hasOne(Bonus::class, ['id' => 'type']);
    }
}
