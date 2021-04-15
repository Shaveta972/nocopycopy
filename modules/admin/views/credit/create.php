<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CreditScanSettings */

$this->title = 'Create Credit Scan Settings';
$this->params['breadcrumbs'][] = ['label' => 'Credit Scan Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="credit-scan-settings-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
