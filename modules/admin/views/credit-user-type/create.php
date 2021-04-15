<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CreditUserSettings */

$this->title = 'Create Credit User Settings';
$this->params['breadcrumbs'][] = ['label' => 'Credit User Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="credit-user-settings-create">

    <?= $this->render('_form', [
        'model' => $model,
        'listData' => $listData
    ]) ?>

</div>
