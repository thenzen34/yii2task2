<?php

namespace app\commands;

use app\models\Bonus;
use app\models\Calls;
use app\models\CallsByDay;
use app\models\CallsByMonth;
use app\models\Managers;
use DateTime;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Class JobsController
 * @package app\commands
 */
class JobsController extends Controller
{
    /**
     * заполняем справочники
     *
     * @return int
     * @throws \yii\db\Exception
     */
    public function actionInit()
    {
        Managers::deleteAll();

        $model = new Managers();
        $model->name = 'Хельга Браун';
        $model->salary = 20000;
        $model->save();

        $model = new Managers();
        $model->name = 'Барак Обама';
        $model->salary = 30000;
        $model->save();

        $model = new Managers();
        $model->name = 'Денис Козлов';
        $model->salary = 40000;
        $model->save();

        Bonus::deleteAll();

        $columns = [
            'name',
            'salary',

            'from',
            'to',
        ];
        $rows = [
            [
                'name' => 'Начальная',
                'salary' => 100,

                'from' => 0,
                'to' => 100,
            ],
            [
                'name' => 'Средняя',
                'salary' => 200,

                'from' => 100,
                'to' => 200,
            ],
            [
                'name' => 'Высшая',
                'salary' => 300,

                'from' => 300,
                'to' => 5000,
            ],
        ];

        Bonus::getDb()->createCommand()->batchInsert(Bonus::tableName(), $columns, $rows)->execute();

        return ExitCode::OK;
    }

    /**
     * заполняем последние пол года статой звонков
     * 3 человека * 6 месяцев * 300 = 5400
     *
     * @return int
     * @throws \yii\db\Exception
     */
    public function actionGenerate($cntCalls = 5400)
    {
        $date_to = time();
        $date_from = strtotime('- 6 month');

        $manargers_ids = Managers::getAllIds();

        $count_managers = count($manargers_ids);

        if ($count_managers < 1) {
            return ExitCode::OK;
        }

        $columns = [
            'manager_id',
            'dt',
        ];
        $rows = [];
        for ($i = 0; $i < $cntCalls; $i++) {
            $manager_id = $manargers_ids[ array_rand($manargers_ids, 1) ];

            $timestamp = mt_rand($date_from, $date_to);
            $rows[] = [
                'manager_id' => $manager_id,
                'dt' => date('Y-m-d H:i:s', $timestamp),
            ];
        }

        Calls::deleteAll();

        Calls::getDb()->createCommand()->batchInsert(Calls::tableName(), $columns, $rows)->execute();

        /**
         * агрегируем по дням на основе лога звонков
         */
        CallsByDay::deleteAll();

        $begin = new DateTime(date('Y-m-d', $date_from));
        $end = new DateTime(date('Y-m-d', $date_to));

        for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
            CallsByDay::runStored($i->format('Y-m-d'));
        }

        /**
         * агрегируем по месяцам на основе дневной статы
         */
        CallsByMonth::deleteAll();

        $begin = new DateTime(date('Y-m-d', $date_from));
        $end = new DateTime(date('Y-m-d', $date_to));

        for ($i = $begin; $i <= $end; $i->modify('+1 month')) {
            CallsByMonth::runStored($i->format('Y-m-d'));
        }

        return ExitCode::OK;
    }

    /**
     * запускаем по крону для автоматической агрегации
     *
     * @param bool|int $date
     * @throws \yii\db\Exception
     */
    public function actionCalcByDay($date = false)
    {
        //по умолчанию считаем за вчера
        if ($date === false) {
            $date = strtotime('- 1 day');
        }

        $begin = date('Y-m-d', $date);
        CallsByDay::runStored($begin);
    }

    /**
     * запускаем по крону для автоматической агрегации
     *
     * @param bool|int $date
     * @throws \yii\db\Exception
     */
    public function actionCalcByMonth($date = false)
    {
        //по умолчанию считаем за вчера
        if ($date === false) {
            $date = strtotime('- 1 day');
        }

        $begin = date('Y-m-d', $date);
        CallsByMonth::runStored($begin);
    }
}
