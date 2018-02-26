<?php

namespace app\models;

use app\models\query\CallsByDayQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "yii2task2.calls_by_day".
 *
 * @property int $id
 * @property int $manager_id
 * @property string $date
 * @property int $calls
 *
 * @property Managers $managers
 */
class CallsByDay extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yii2task2.calls_by_day';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['manager_id', 'date'], 'required'],
            [['manager_id', 'calls'], 'default', 'value' => null],
            [['manager_id', 'calls'], 'integer'],
            [['date'], 'safe'],
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
        ];
    }

    /**
     * @inheritdoc
     * @return CallsByDayQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CallsByDayQuery(get_called_class());
    }

    public function getManagers()
    {
        return $this->hasOne(Managers::class, ['id' => 'type']);
    }
}
