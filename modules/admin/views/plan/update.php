<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Plans */

$this->title = 'Update Plans: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="plans-update">

    <?= $this->render('_form', [
        'model' => $model,
        'listData' => $listData
    ]) ?>

</div>
