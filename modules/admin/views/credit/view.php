<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\widgets\PageHeader;
/* @var $this yii\web\View */
/* @var $model app\models\CreditScanSettings */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Credit Scan Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= PageHeader::widget([
        'title'=>'View Record'
    ]) ?>

<div class="credit-scan-settings-view box box-primary">

    <div class="box-header with-border">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    </div>
    <div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'doc_type',
            'credit_value',
            'created_at:datetime',
            'updated_at:datetime',
            // [
            //         'attribute'=>    'created_by',
            //         'value'=>$model->createdBy ? $model->createdBy->fullName : 'NA'
            // ],    
        ],
    ]) ?>
</div>
</div>
