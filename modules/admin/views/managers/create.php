<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Managers */

$this->title = 'Create Managers';
$this->params['breadcrumbs'][] = ['label' => 'Managers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="managers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
