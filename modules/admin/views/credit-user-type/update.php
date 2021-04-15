<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CreditUserSettings */

$this->title = 'Update Credit User Settings: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Credit User Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="credit-user-settings-update">

    <?= $this->render('_form', [
        'model' => $model,
        'listData' => $listData
    ]) ?>

</div>
