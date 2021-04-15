<?php
use yii\helpers\Url;
use yii\bootstrap\Html;
use app\widgets\PageHeader;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SubjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Subjects';
$this->params['breadcrumbs'][] = $this->title;
?>
 	<?= PageHeader::widget([
    	'title'=>$this->title,
    ]) ?>



<div class="container">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5"> 
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="pb-2 fw-bold panel-header-heading">Subjects List</h2>
                </div>
            </div>
        </div>
    </div>
<div class="page-inner mt--5 manage_jobs members">
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
                        <div class="create_job">
                        <?= Html::a('Create Subjects', ['create'], ['class' => 'btn  btn-blue']) ?>
                            <!-- <a href="create_job.html" class="btn btn-border">
                            <img src="../assets/images/create_job.svg"> Export as PDF</a>  -->
                        </div>
                    </div>
                </div>
                <div class="card-body">
                     <div class="manage_table">
                     <?php Pjax::begin(['id' => 'lecturer-users']) ?>
                     <div class="table-responsive">
                     <?php
                            echo GridView::widget([
                                'dataProvider' => $dataProvider,
                                'pjax' => true,
                                'pjaxSettings' => [
                                    'options' => [
                                        'id' => 'data-grid',
                                    ]
                                ],
                                'responsive' => true,
                                'columns' => [
                                    ['class' => '\kartik\grid\SerialColumn'],
                                    'created_at:datetime',
                                    'subject_name',
                                    'subject_code',
                                    [
                                        'class' => 'kartik\grid\ActionColumn',
                                        'template' => '{view}',
                                        'buttons' => [
                                            'view' => function ($url, $data) {
                                                return Html::a(
                                                    'View Assignments',
                                                    Url::to(['user/assignments/' . $data->subject_code]),
                                                    [
                                                        'class' => ' text-white btn-blue btn',   'title' => 'View Assignments', 'target' => '_blank', 'data-pjax' => "0"
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
                        <?php Pjax::end(); ?>
                                
                             
                    </div>
                    </div>
                </div>
            </div>						
        </div>
    </div>
</div>
