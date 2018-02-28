<?php

namespace app\controllers\site;

use app\models\Bonus;
use app\models\CallsByMonth;
use app\models\Managers;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * @method renderPartial(string $view, array $params)
 * @method render(string $view, array $params = [])
 *
 */
trait IndexTrait
{

    private function _getSorterIndex()
    {
        return [
            'defaultOrder' => [
                'id' => SORT_ASC,
            ],
            'attributes' => [
                'name' => [
                    'asc' => [new Expression('managers.name ASC NULLS LAST')],
                    'desc' => [new Expression('managers.name DESC NULLS LAST')],
                    'default' => SORT_DESC,
                    'label' => 'По имени',
                ],
                'id' => [
                    'asc' => [new Expression('managers.id ASC NULLS LAST')],
                    'desc' => [new Expression('managers.id DESC NULLS LAST')],
                    'default' => SORT_DESC,
                    'label' => 'По id',
                ],
                'salary' => [
                    'asc' => [new Expression('managers.salary ASC NULLS LAST')],
                    'desc' => [new Expression('managers.salary DESC NULLS LAST')],
                    'default' => SORT_DESC,
                    'label' => 'По окладу',
                ],
                'lastMonth.calls' => [
                    'asc' => [new Expression('calls_by_month.calls ASC NULLS LAST')],
                    'desc' => [new Expression('calls_by_month.calls DESC NULLS LAST')],
                    'default' => SORT_DESC,
                    'label' => 'По окладу',
                ],
                'lastMonth.bonus.salary' => [
                    'asc' => [new Expression('bonus.salary ASC NULLS LAST')],
                    'desc' => [new Expression('bonus.salary DESC NULLS LAST')],
                    'default' => SORT_DESC,
                    'label' => 'По окладу',
                ],
                'total' => [
                    'asc' => [new Expression('(bonus.salary + managers.salary) ASC NULLS LAST')],
                    'desc' => [new Expression('(bonus.salary + managers.salary) DESC NULLS LAST')],
                    'default' => SORT_DESC,
                    'label' => 'По окладу',
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $provider = new ActiveDataProvider([
            'query' => Managers::find()
                //->innerJoinWith('lastMonth')
                ->joinWith('lastMonth.bonus')
            ,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => $this->_getSorterIndex()
        ]);

        $provider2 = new ActiveDataProvider([
            'query' => Managers::find()->alias('managers')
                ->select([
                    'id' => 'managers.id',
                    'name' => 'managers.name',
                    'salary' => 'managers.salary',
                    'calls' => 'calls_by_month.calls',
                    'total' => 'managers.salary+(COALESCE(bonus.salary, 0))',
                    'bonus' => '(case when calls_by_month.bonus_id is null then 0::text else bonus.salary::text || \' (\' || bonus.name || \')\' end)',
                ])
                ->innerJoin(['calls_by_month'=>CallsByMonth::tableName()], 'calls_by_month.manager_id = managers.id and calls_by_month.date >= now()-\'1 month\'::interval')
                ->leftJoin(['bonus'=>Bonus::tableName()], 'calls_by_month.bonus_id = bonus.id')
                ->asArray()
            ,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => $this->_getSorterIndex()
        ]);

        $managers = Managers::find()
            ->with(['lastMonth', 'lastMonth.bonus'])
            ->all();

        return $this->render('index', [
            'managers' => $managers,
            'provider' => $provider,
            'provider2' => $provider2,
        ]);
    }

}