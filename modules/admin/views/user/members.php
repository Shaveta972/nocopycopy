<?php
use app\widgets\GridView;
use app\widgets\PageHeader;
use yii\widgets\Pjax;
use yii\bootstrap\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Members List');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= PageHeader::widget(['title' => $this->title]) ?>
<div class="user-index box box-primary">
    <?php 
    ?>
   
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
                'allocated_credits',
                [
                    'attribute' => 'state_id',
                    'class' => '\dixonstarter\togglecolumn\ToggleColumn'
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
                                     Url::to(['user/details/' . $data->id]),[
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