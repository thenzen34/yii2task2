<?php

namespace app\models\query;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\CallsByMonth]].
 *
 * @see \app\models\CallsByMonth
 */
class CallsByMonthQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\models\CallsByMonth[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\CallsByMonth|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
