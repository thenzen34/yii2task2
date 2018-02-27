<?php

/* @var $this yii\web\View */

use app\models\Managers;

$this->title = 'My Yii Application';

/* @var Managers[] $managers */
?>
<div class="site-index">

    <div class="jumbotron">
        <p>Информация по зп за послдений месяц</p>
    </div>

    <div class="body-content">

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
