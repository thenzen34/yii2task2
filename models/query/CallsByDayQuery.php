<?php

namespace app\models\query;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\CallsByDay]].
 *
 * @see \app\models\CallsByDay
 */
class CallsByDayQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\models\CallsByDay[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\CallsByDay|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
