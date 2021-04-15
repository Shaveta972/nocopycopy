<?php
use yii\helpers\Url;
use yii\bootstrap\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
$this->title = \Yii::t('app', 'Students');
\yii\web\YiiAsset::register($this);
echo \yii2mod\alert\Alert::widget();
?>

<div class="container">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5"> 
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="pb-2 fw-bold panel-header-heading">Students List</h2>
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
                                'dataProvider' => $referralStudentdataProvider,
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
                                        'label' => 'FirstName',
                                        'value' => function ($data) {
                                            return  ucwords($data->first_name . " " . $data->last_name);
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
                                        'label' => 'Role',
                                        'value' => function ($data) {
                                            return $data->getSubAdminState($data->is_subadmin);
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
                                        'label' => 'Allocated Credits',
                                        'value' => function ($data) {
                                            return $data->business_credits;
                                        },
                                    ],

                                    [
                                        'class' => 'kartik\grid\BooleanColumn',
                                        // 'attribute' => 'is_confirmed',
                                        'label' => 'Confirm',
                                        'vAlign' => 'middle',
                                        'value' => function ($data) {
                                            return $data->is_confirmed;
                                        },
                                    ],
                                    [
                                        'class' => 'kartik\grid\BooleanColumn',
                                        //  'attribute' => 'state_id',
                                        'label' => 'Active',
                                        'vAlign' => 'middle',
                                        'value' => function ($data) {
                                            return $data->state_id;
                                        },
                                    ],
                                    [
                                        'format' => 'html',
                                        'attribute' => 'is_admin_approve',
                                        'label' => 'Approve Status',
                                        'value' => function ($data) {
                                            return ($data->is_admin_approve == 1) ? '<span class="label label-md label-primary">' . $data->getApproveStatus($data->is_admin_approve) . '</span>'
                                                : '<span class="label label-md label-warning">' . $data->getApproveStatus($data->is_admin_approve) . '</span>';
                                        }

                                    ],

                                    [
                                        'class' => 'kartik\grid\ActionColumn',
                                        'template' => '{view}{approve}',
                                        'buttons' => [
                                            'view' => function ($url, $data) {
                                                return Html::a(
                                                    'View',
                                                    Url::to(['user/details/' . $data->id]),
                                                    [
                                                        'class' => ' text-white btn-blue btn btn-xs',   'title' => 'View User Details', 'target' => '_blank', 'data-pjax' => "0"
                                                    ]
                                                );
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




