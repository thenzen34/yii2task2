<?php

/* @var $this yii\web\View */

use app\models\Managers;
use yii\data\ActiveDataProvider;

$this->title = 'My Yii Application';

/* @var Managers[] $managers */

/* @var ActiveDataProvider $provider */

/* @var ActiveDataProvider $provider2 */
?>
<div class="site-index">

    <div class="jumbotron">
        <p>Информация по зп за послдений месяц</p>
    </div>

    <div class="body-content">

        <?= \yii\grid\GridView::widget([
            'caption' => 'Используя query Builder',
            'tableOptions' => [
                'class' => 'table'
            ],
            'rowOptions' => [
                'class' => 'active'
            ],
            'dataProvider' => $provider2,
            'columns' => [
                [
                    'attribute' => 'id',
                    'label' => '#',
                ],
                'name',
                'salary',
                [
                    'attribute' => 'lastMonth.calls',
                    'value' => function ($data) {
                        return number_format($data['calls'], 0, ' ', ',');
                    }
                ],
                [
                    'attribute' => 'lastMonth.bonus.salary',
                    'value' => function ($data) {
                        return $data['bonus'];
                    }
                ],
                [
                    'attribute' => 'total',
                    'label' => 'Итого',
                    'value' => function ($data) {
                        return number_format($data['total'], 0, ' ', ',');
                    }
                ],
            ],
        ])?>

        <?= \yii\grid\GridView::widget([
            'caption' => 'Используя activerecord',
            'tableOptions' => [
                'class' => 'table'
            ],
            'rowOptions' => [
                'class' => 'active'
            ],
            'dataProvider' => $provider,
            'columns' => [
                [
                    'attribute' => 'id',
                    'label' => '#',
                ],
                'name',
                'salary',
                'lastMonth.calls',
                [
                    'attribute' => 'lastMonth.bonus.salary',
                    'label' => 'Бонус',
                    'value' => function ($model) {

                        /** @var Managers $model */
                        $has_bonus = $model->lastMonth->bonus !== null;

                        return $has_bonus ? (number_format($model->lastMonth->bonus->salary, 0,
                                ' ', ',') . ' (' . $model->lastMonth->bonus->name . ')') : 0;
                    }
                ],
                [
                    'attribute' => 'total',
                    'label' => 'Итого',
                    'value' => function ($model) {

                        /** @var Managers $model */
                        $has_bonus = $model->lastMonth->bonus !== null;
                        $total = $model->salary;

                        if ($has_bonus) {
                            $total += $model->lastMonth->bonus->salary;
                        }

                        return number_format($total, 0, ' ', ',');
                    }
                ],
            ],
        ])?>

        <p>Простым циклом</p>
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Менеджер</th>
                <th>Оклад</th>
                <th>Звонков совершенно</th>
                <th>Бонус</th>
                <th>Итого:</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($managers as $manager) {
                $has_bonus = $manager->lastMonth->bonus !== null;
                $total = $manager->salary;

                if ($has_bonus) {
                    $total += $manager->lastMonth->bonus->salary;
                }
                ?>
                <tr class="active">
                    <th scope="row"><?= $manager->id ?></th>
                    <td><?= $manager->name ?></td>
                    <td><?= $manager->salary ?></td>
                    <td><?= $manager->lastMonth->calls ?></td>
                    <td><?= $has_bonus ? (number_format($manager->lastMonth->bonus->salary, 0,
                                ' ', ',') . ' (' . $manager->lastMonth->bonus->name . ')') : 0 ?></td>
                    <td><?= number_format($total, 0, ' ', ',') ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>

    </div>
</div>
