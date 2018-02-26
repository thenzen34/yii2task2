<?php

namespace app\models;

use app\models\query\CallsQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "yii2task2.calls".
 *
 * @property int $id
 * @property int $manager_id
 * @property string $dt
 *
 * @property Managers $managers
 */
class Calls extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yii2task2.calls';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['manager_id'], 'required'],
            [['manager_id'], 'default', 'value' => null],
            [['manager_id'], 'integer'],
            [['dt'], 'safe'],
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
            'dt' => 'Dt',
        ];
    }

    /**
     * @inheritdoc
     * @return CallsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CallsQuery(get_called_class());
    }

    public function getManagers()
    {
        return $this->hasOne(Managers::class, ['id' => 'type']);
    }
}
