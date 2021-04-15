<?php

use yii\helpers\Url;
use yii\bootstrap\Html;
/* @var $this yii\web\View */
/* @var $model app\models\User */
//use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\StringHelper;
use app\models\UserRecords;

$this->title = \Yii::t('app', 'Assignments');
\yii\web\YiiAsset::register($this);
echo \yii2mod\alert\Alert::widget();
?>


<div class="container">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5"> 
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="pb-2 fw-bold panel-header-heading">Assignments- <?= $subject_code ?></h2>
                </div>
            </div>
        </div>
    </div>
<div class="page-inner mt--5 manage_jobs members">
    <div class="row mt--2">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header d-flex">
                    <div class="header_right pb-2">
                        <div class="date_box">
                            <label> Date Filter</label>  
                                <div class="input-group">
                                    <input type="text" class="form-control success" id="birth" name="birth" required="" aria-invalid="false" placeholder="Select Date">
                                    <div class="input-group-append d-flex">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar-o"></i>
                                        </span>
                                    </div>
                                </div>
                        </div>
                        <div class="create_job"><a href="create_job.html" class="btn btn-border">
                            <img src="../assets/images/create_job.svg"> Export as PDF</a> 
                        </div>
                    </div>
                </div> -->
                <div class="card-body">
                    <div class="manage_table">
                    <?php Pjax::begin(['id' => 'staff-grid']) ?>
                    <div class="table-responsive">
                            <?php
                            echo GridView::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    ['class' => 'kartik\grid\SerialColumn'],

                                    [
                                        // 'attribute' => 'created_at',
                                        'class' => 'yii\grid\DataColumn',
                                        'label' => 'Date',
                                        'value' => function ($model) {
                                            return Yii::$app->formatter->asDate($model->created_at, 'full'); // 30-Mar-2017
                                        },
                                    ],
                                    [
                                        // 'attribute' => 'created_at',
                                        'class' => 'yii\grid\DataColumn',
                                        'label' => 'Student Name',
                                        'value' => function ($model) {
                                            return $model->user->first_name . " " . $model->user->last_name; // 30-Mar-2017
                                        },
                                    ],
                                    [
                                        // 'attribute' => 'created_at',
                                        'class' => 'yii\grid\DataColumn',
                                        'label' => 'Email',
                                        'value' => function ($model) {
                                            return $model->user->email;
                                        },
                                    ],
                            


                                    [
                                        'class' => 'kartik\grid\DataColumn', // can be omitted, as it is the default
                                        'label' => 'Assignment',
                                        'format' => 'raw',
                                        'value' => function ($data) {
                                            if($data->process_type == 'file'){
                                                  return Html::a(
                                                StringHelper::truncate($data->process_value, 75).' <i class="fa fa-download icon-text icon-text-xs  ml-auto pl-3"></i>',
                                            Url::to(['user/download/' . $data->id   ]),
                                            ['title' => 'View Records', 'target' => '_blank']
                                        );
                                            }
                                            return StringHelper::truncate($data->process_value, 75);
                                        },
                                    ],
                                    [
                                        'class' => 'kartik\grid\DataColumn', // can be omitted, as it is the default
                                        'label' => 'Status',
                                        'format' => 'html',
                                        'value' => function ($data) {
                                            if ($data->state_id === 0) {
                                                $options = ['class' => 'loader loader-4'];
                                                return  Html::tag('div', '<span></span><span></span>
                                                    <span></span>', $options);
                                            }
                                            return UserRecords::getState($data->state_id);
                                        }
                                    ],
                                    [
                                        'class' => 'kartik\grid\DataColumn', // can be omitted, as it is the default
                                        'label' => 'Copied Words',
                                        'format' => 'html',
                                        'value' => function ($data) {
                                            return UserRecords::getResult($data->process_id);
                                        }
                                    ],

                                
                                    [
                                        'class' => 'kartik\grid\ActionColumn',
                                        'template' => '{results}',
                                        'buttons' => [
                                            'results' => function ($url, $data) {
                                                if ($data->state_id === 1) {
                                                    // $url = Url::to(['scan/results/' . $data->process_id]);
                                                    return Html::a(
                                                        '<i class="fa fa-arrow-circle-o-right icon-text icon-text-xs fa-2x text-danger ml-auto pl-3"></i>',
                                                        Url::to(['scan/results/' . $data->process_id]),
                                                        ['title' => 'View Records', 'target' => '_blank']
                                                    );
                                                } else {
                                                    return Html::a(
                                                        '<i class="fa fa-ban icon-text icon-text-xs fa-2x text-muted ml-auto pl-3"></i>',
                                                        'javascript:void(0)',
                                                        ['title' => '',]
                                                    );
                                                }
                                            },
                                        ],
                                    ],
                                ],
                                'pager' => [
                                    'prevPageLabel' => 'Previous',
                                    'nextPageLabel' => 'Next',
                                    'linkOptions' => ['class' => 'page-link'],
                                    'activePageCssClass' => 'myactive page-item',
                                    'disabledPageCssClass' => 'disabled page-item',
                                    'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link']
                                ],
                                'tableOptions' => [
                                    'class' => 'table',
                                ],
                                'bootstrap' => false,
                                'summary' => ''
                            ]);
                            ?>
                        </div>
                                <?php Pjax::end() ?>
                    </div>
                    </div>
                </div>
            </div>						
        </div>
    </div>
</div>




