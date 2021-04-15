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

$this->title = \Yii::t('app', 'View Referals');
\yii\web\YiiAsset::register($this);
echo \yii2mod\alert\Alert::widget();
?>
<div class="refer-users mt-2">
    <div class="container">
        <div class="theme-heading text-left">
            <h1>Referals</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="invite-sec mb-5 card">
                    <h5 class="card-header">Invite Team Members</h5>
                    <div class="card-body">
                        <?php $form = ActiveForm::begin([
                            'id' => 'send-invitation-form',
                            'action' =>  Url::to(['user/send-invitation-link'])
                        ]); ?>
                        <div class="md-form mb-4">
                            <?php
                            echo $form->field($model, 'email', [
                                'options' => ['class' => 'form-group col-md-12 mb-0'],
                                'template' => '{input}{hint}{error}'
                            ])->textInput([
                                'placeholder' => "Email"
                            ]);
                            ?>
                            <!-- <input type="text" class="form-control" placeholder="Recipient's email" aria-label="Recipient's email" aria-describedby="MaterialButton-addon2"> -->
                        </div>
                        <div class="form-group col-md-12">
                            <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-main']); ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                        <!-- <div style="width: 100%;height: 19px;border-bottom: 1px solid #ced4da;text-align: center;z-index: 0;margin: 0 auto;/* padding: 20px 0; */">
                            <span style="font-size: 20px;background-color: white;padding: 0 10px;color: cokr;color: red;">
                                or
                            </span>
                        </div> -->
                        <!-- <div class="social-share-section mt-4">
                            <h6>Your Personal Referal Link</h6>
                            <input type="email" class="form-control" id="inputEmail3MD" placeholder="http://localhost:8080/user/referals/78965413">
                            <div class="link-share mt-4">
                                <div class="footer-social-icons">
                                    <h6 class="_14">Share your Link</h6>
                                    <ul class="social-icons">
                                        <li><a href="" class="social-icon"> <i class="fa fa-facebook"></i></a></li>
                                        <li><a href="" class="social-icon"> <i class="fa fa-twitter"></i></a></li>
                                        <li><a href="" class="social-icon"> <i class="fa fa-google-plus"></i></a></li>
                                    </ul>
                                </div>

                                <div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="card referal-users">
                    <h5 class="card-header">Your Team Members</h5>
                    <div class="card-body">
                        <?php
                        Pjax::begin(['id' => 'data-grid', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]); ?>
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
                                'responsive' => false,
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
                                        'class' => 'kartik\grid\BooleanColumn',
                                        'label' => 'Email Confirmed',
                                        'vAlign' => 'middle',
                                        'value' => function ($data) {
                                            return $data->is_confirmed;
                                        },
                                    ],
                                    [
                                        'class' => 'kartik\grid\EditableColumn',
                                        'label' => 'Assign Credits',
                                        'attribute' => 'business_credits',
                                        'readonly' => function ($model, $key, $index, $widget) {
                                            return ($model->business_credits != 0); // do not allow editing of inactive records
                                        },
                                        'editableOptions' => [
                                            'header' => 'Credits',
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
                                    'class' => 'table table-condensed',
                                ],
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
            <?php
            //         echo $this->registerJs(' 
            // setInterval(function(){  
            //      $.pjax.reload({container:"#data-grid"});
            // }, 20000);', \yii\web\VIEW::POS_HEAD);
            //         
            ?>
            <!-- <script>

// $.pjax.reload({container:'#employee'}); //refresh the grid

</script> -->