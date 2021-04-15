<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Plans */

$this->title = 'Create Plans';
$this->params['breadcrumbs'][] = ['label' => 'Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plans-create">

    <?= $this->render('_form', [
        'model' => $model,
        'listData' => $listData,
    ]) ?>

</div>
