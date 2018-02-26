<?php

namespace app\models;

use app\models\query\ManagersQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "yii2task2.managers".
 *
 * @property int $id
 * @property string $name
 * @property int $salary
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
            'name' => 'Name',
            'salary' => 'Salary',
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
}
