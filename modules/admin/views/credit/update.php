<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CreditScanSettings */

$this->title = 'Update Credit Scan Settings: ' . $model->doc_type;
$this->params['breadcrumbs'][] = ['label' => 'Credit Scan Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="credit-scan-settings-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
