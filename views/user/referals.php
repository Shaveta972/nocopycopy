<?php

use yii\helpers\Url;
use yii\bootstrap\Html;
/* @var $this yii\web\View */
/* @var $model app\models\User */
//use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\editable\Editable;
use app\models\User;
$this->title = \Yii::t('app', 'View Referals');
\yii\web\YiiAsset::register($this);
echo \yii2mod\alert\Alert::widget();
?>
<div class="container">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">   
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="pb-2 fw-bold panel-header-heading">Manage Referrals</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner mt--5 referrals">
		<div class="row mt--2">
            <div class ="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
						    <div class="col-md-10 col-sm-10	form_box">
                                <h4 class="card-heading">Invite Team Members</h4>
                                    <?php $form = ActiveForm::begin(
                                        [   'id' => 'send-invitation-form',
                                            'action' =>  Url::to(['user/send-invitation-link']),
                                            'options' => ['class' => 'form-group form-show-validation row']]) ?>
                                    <div class="col-md-6">
                                        <?php
                                            echo $form->field($model, 'email', [ 'options' => ['class' => ''], 'template' => '{input}{hint}{error}'
                                            ])->textInput(['placeholder' => "Email"]);
                                        ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-main']); ?>
                                    </div>
                                    <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-md-12 col-sm-12 manage_jobs">
                        <div class="card">
                        <div class="card-header">
											<div class="card-title">Members List</div>
										</div>
                            <!-- <div class="card-header d-flex">
                                <ul class="tabs tabs_ul">
                                    <li class="tab-link current" data-tab="tab-1">Upcoming</li>
                                    <li class="tab-link" data-tab="tab-2">Completed</li>
                                    <li class="tab-link" data-tab="tab-3">Jobs Posted</li>
                                    <li class="tab-link" data-tab="tab-4">All</li>
                                </ul>
                                <div class="header_right">
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
                            </div> -->
						<!-- </div> -->
								<div class="card-body manage_table">
                                    <?php Pjax::begin(['id' => 'data-grid', 'timeout' => false, 'enablePushState' => false, 
                                    'clientOptions' => ['method' => 'POST']]); ?>
                                    <div class="table-responsive">
                                        <?php
                                    echo GridView::widget([
                                        'dataProvider' => $dataProvider,
                                        'containerOptions' => ['style'=>'overflow: auto'],
                                        'pjax' => true,
                                        'pjaxSettings' => [
                                            'options' => [
                                                'id' => 'data-grid',
                                            ]
                                        ],
                                        'responsive' => true,
                                        'columns' => [
                                    ['class' => '\kartik\grid\SerialColumn'],
                                    [
                                        'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                        'label' => 'FullName',
                                        'format' => 'html',
                                        'value' => function ($data) {
                                            return Html::a(
                                                ucwords($data->first_name . " " . $data->last_name),
                                                Url::to(['user/details/' . $data->id]),
                                                [
                                                    'target' => '_blank', 'data-pjax' => "0"
                                                ]
                                            );
                                        },
                                    ],
                                    [
                                        'class' => '\kartik\grid\DataColumn', // can be omitted, as it is the default
                                        'label' => 'Email',
                                        'value' => function ($data) {
                                            return $data->email;
                                        },
                                    ],
                                    [
                                        'class' => '\kartik\grid\DataColumn', // can be omitted, as it is the default
                                        'label' => 'Personal Credits',
                                        'value' => function ($data) {
                                            return $data->personal_credits;
                                        },
                                    ],
                                    [
                                        'class' => '\kartik\grid\DataColumn', // can be omitted, as it is the default
                                        'label' => 'Business Credits',
                                        'value' => function ($data) {
                                            return $data->business_credits;
                                        },
                                    ],
                                    [
                                        'class' => '\kartik\grid\DataColumn', // can be omitted, as it is the default
                                        'label' => 'Allocated Credits',
                                        'value' => function ($data) {
                                            return $data->allocated_credits;
                                        },
                                    ],
                                    [
                                        'class' => 'kartik\grid\BooleanColumn',
                                        'label' => 'Approved',
                                        'vAlign' => 'middle',
                                        'value' => function ($data) {
                                            return User::getApproveStatus($data->is_admin_approve);
                                        },
                                    ],
                                    [
                                        'class' => 'kartik\grid\EditableColumn',
                                        'label' => 'Assign Credits',
                                        'attribute' => 'allocated_credits',
                                        'readonly' => function ($model, $key, $index, $widget) {
                                            return ($model->allocated_credits != 0); // do not allow editing of inactive records
                                        },
                                        'editableOptions' => [
                                            'header' => 'Credits',
                                            'placement' => 'left',
                                            'inputType' => Editable::INPUT_SPIN,
                                            'options' => [
                                                'pluginOptions' => ['min' => 0, 'max' => 5000]
                                            ],
                                            'pluginEvents' => [
                                                "editableSuccess" => "function(event, val, form, data) {
                                                    $.pjax.reload({container: '#data-grid'});
                                            }",
                                            ],
                                        ],
                                        'vAlign' => 'middle',
                                        'format' => ['decimal', 2],
                                        // 'pageSummary' => true
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
                        <?php
                        Pjax::end();
                        ?>	
                    </div>
                </div>
            </div>
        </div>
                
		</div>
    </div>
</div>