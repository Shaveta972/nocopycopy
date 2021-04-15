<?php

use yii\bootstrap\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
$this->title = \Yii::t('app', 'My Transactions');
\yii\web\YiiAsset::register($this);
echo \yii2mod\alert\Alert::widget();
?>

<div class="container">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="pb-2 fw-bold panel-header-heading">My Transactions</h2>
                </div>
            </div>
        </div>
    </div>
<div class="page-inner mt--5 manage_jobs">
    <div class="row mt--2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex">
                    <div class="header_right pb-2">
                        <!-- <div class="date_box">
                            <label> Date Filter</label>  
                                <div class="input-group">
                                    <input type="text" class="form-control success" id="birth" name="birth" required="" aria-invalid="false" placeholder="Select Date">
                                    <div class="input-group-append d-flex">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar-o"></i>
                                        </span>
                                    </div>
                                </div>
                        </div> -->
                        <!-- <div class="create_job"><a href="create_job.html" class="btn btn-border">
                            <img src="../assets/images/create_job.svg"> Export as PDF</a> 
                        </div> -->
                    </div>
                </div>
                <div class="card-body">
                    <div class="manage_table">
                        <?php Pjax::begin(['id' => 'billing']) ?>
                            <div class="table-responsive">
                                <?php echo GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn'],
                                        [
                                            // 'attribute' => 'created_at',
                                            'class' => 'yii\grid\DataColumn',
                                            'label' => 'Date',
                                            'value' => function ($model) {
                                                return Yii::$app->formatter->asDate($model->created_at, 'full'); // 30-Mar-2017
                                            },
                                        ],
                                        [
                                            'class' => 'yii\grid\DataColumn',
                                            'label' => 'Reference ID',
                                            'value' => function ($model) {
                                                return $model->reference_id; // 30-Mar-2017
                                            },
                                        ],
                                        [
                                            'attribute' => 'amount_paid',
                                            'class' => 'yii\grid\DataColumn',
                                            'label' => 'Amout Paid',
                                            'value' => function ($model) {
                                                return $model->amount_paid . " " . "NGN";  // 30-Mar-2017
                                            },
                                        ],
                                        [
                                            'attribute' => 'card_type',
                                            'class' => 'yii\grid\DataColumn',
                                            'label' => 'Payment Mode',
                                            'value' => function ($model) {
                                                return $model->card_type;  // 30-Mar-2017
                                            },
                                        ],
                                        [
                                            'class' => 'yii\grid\DataColumn',
                                            'label' => 'Status',
                                            'value' => function ($model) {
                                                // return  $model->status;
                                                if ($model->is_cancel == 1) {
                                                    return "Cancelled";
                                                } else if ($model->isExpire == 1) {
                                                    return "Expired";
                                                } else if ($model->status == 1) {
                                                    return "Active";
                                                }
                                            },
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
                            <?php Pjax::end(); ?>
                        </div>
                    </div>
                </div>
            </div>						
        </div>
    </div>
</div>




