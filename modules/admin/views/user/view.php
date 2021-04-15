<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\widgets\PageHeader;
/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->fullName;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Users'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>

<?=PageHeader::widget ( [ 'title' => $this->title ] )?>

<div class="user-view box box-primary">

	<div class="box-header with-border">
		<p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=Html::a ( Yii::t ( 'app', 'Delete' ), [ 'delete','id' => $model->id ], [ 'class' => 'btn btn-danger','data' => [ 'confirm' => Yii::t ( 'app', 'Are you sure you want to delete this item?' ),'method' => 'post' ] ] )?>
    </p>
	</div>
	<div class="box-body">
    <?php

    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'first_name',
            'last_name',
            'username',
            'email:email',
            [
                'attribute' => 'role',
                'value' => $model->getRole($model->role)
            ],
            [
                'format' => 'raw',
                'attribute' => 'state_id',
                'value' => function ($data) {
                    return  ($data->state_id == 1) ? '<p style="font-size:16px;margin-bottom:5px;"><span class="label label-md label-success">'.$data->getState($data->state_id).'</span></p>'
                    : '<p style="font-size:16px;margin-bottom:5px;"><span class="label label-md label-danger">'.$data->getState($data->state_id).'</span></p>';
                }
                // 'value' => $model->getState($model->state_id)
            ],
            [
                'format' => 'raw',
                'attribute' => 'is_admin_approve',
                'label' => 'Approve Status',
                'value' => function ($data) {
                  return ($data->is_admin_approve == 1) ? 
                  '<p style="font-size:16px;margin-bottom:0px;"><span class="label label-md label-success">'.$data->getApproveStatus($data->is_admin_approve).'</span></p>' : (($data->is_admin_approve === 2) ? 
                 '<p style="font-size:16px;margin-bottom:0px;"><span class="label label-md label-danger">'.$data->getApproveStatus($data->is_admin_approve).'</span></p>' : 
                 '<p style="font-size:16px;margin-bottom:0px;"><span class="label label-md label-warning">'.$data->getApproveStatus($data->is_admin_approve).'</span></p>');
                    
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',
            // [
            //     'attribute' => 'created_by',
            //     'value' => $model->createdBy ? $model->createdBy->fullName : 'NA'
            // ]
        ]
    ])?>
</div>
</div>
