<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserCategories */

$this->title = 'Update User Categories: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-categories-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
