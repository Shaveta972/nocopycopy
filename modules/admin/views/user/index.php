<?php
use app\widgets\GridView;
use app\widgets\PageHeader;
use yii\widgets\Pjax;
use yii\bootstrap\Html;
use yii\helpers\Url;
use \yii2mod\alert\Alert;
echo Alert::widget();
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= PageHeader::widget(['title' => $this->title]) ?>
<div class="user-index box box-primary">
    <?php 
    ?>
    <div class="box-header with-border">
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="box-body">
        <?php Pjax::begin(); ?>
        <?php

        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn'
                ],
                'first_name',
                'last_name',
                'email:email',
                'title',
                [
                    'attribute' => 'state_id',
                    'class' => '\dixonstarter\togglecolumn\ToggleColumn'
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'is_admin_approve',
                    'label' => 'Approve Status',
                    'value' => function ($data) {
                      return ($data->is_admin_approve == 1) ? 
                      '<p style="font-size:16px;text-align:center;margin-bottom:0px;"><span class="label label-md label-success">'.$data->getApproveStatus($data->is_admin_approve).'</span></p>' : (($data->is_admin_approve === 2) ? 
                     '<p style="font-size:16px;text-align:center;margin-bottom:0px;"><span class="label label-md label-danger">'.$data->getApproveStatus($data->is_admin_approve).'</span></p>' : 
                     '<p style="font-size:16px;text-align:center;margin-bottom:0px;"><span class="label label-md label-warning">'.$data->getApproveStatus($data->is_admin_approve).'</span></p>');
                        
                    }
                ],
                'created_at:datetime',
                [
                    'class' => 'yii\grid\ActionColumn'
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $data) {
                          
                            if(!empty($data->referrals)){
                                return Html::a(
                                    'View MembersList',
                                     Url::to(['/admin/user/members/', 'id'=> $data->id]),
                                    [
                                       'class'=>'btn btn-sm btn-default', 'title' => 'View User Details', 'target' => '_blank', 'data-pjax' => "0"
                                    ]
                                );
                            }
                         
                  
                          
                        },
                    ],
                ],
            ]
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>

</div>