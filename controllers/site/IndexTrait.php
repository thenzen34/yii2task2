<?php

namespace app\controllers\site;

use app\models\Managers;

/**
 * @method renderPartial(string $view, array $params)
 * @method render(string $view, array $params = [])
 *
 */
trait IndexTrait
{

    public function actionIndex()
    {
        $managers = Managers::find()
            ->with(['lastMonth', 'lastMonth.bonus'])
            ->all();

        return $this->render('index', [
            'managers' => $managers,
        ]);
    }

}