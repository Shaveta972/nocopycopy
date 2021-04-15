<?php

use app\models\UserRecords;
use kartik\grid\GridView;
use yii\bootstrap\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use kartik\widgets\SwitchInput;
use yii\widgets\ActiveForm;

$this->title = \Yii::t('app', 'View Details');
\yii\web\YiiAsset::register($this);
echo \yii2mod\alert\Alert::widget();
?>
<?php
$activeClass = ($model->hasErrors()) ? 'active show' : '';
$indexClass = (!$model->hasErrors()) ? 'active show' : '';
?>
<div class="container">
    <div class="panel-header bg-primary-gradient">
		<div class="page-inner py-5">
			<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
				<div>
					<h2 class="pb-2 fw-bold panel-header-heading">Referral Details</h2>
				</div>
			</div>
		</div>
    </div>

    <div class="page-inner mt--5">
					<div class="row mt--2">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12 col-sm-12 wh_box">
									<div class="card">
										<div class="card-header">
											<div class="card-title">Personal Information</div>
										</div>
										<div class="card-body">
											<div class="row Upcoming_sessoion">
												<div class="col-md-2 col-sm-2 Upcoming_sessoion_img">
                                                    <div class="avatar-md">
                                                        <?php if (empty($model->profile_picture)) {
                                                            echo Html::img('@web/themes/frontend/images/default_avatar.png' , ['class' => 'avatar-img']);
                                                        } else { ?>
                                                            <img src='<?php echo Yii::getAlias('@imagesUrl') . '/' . $model->profile_picture; ?>' class="avatar-img">
                                                        <?php } ?>
                                                    </div>
													
												</div>
                                            <div class="col-md-9 col-sm-9 Upcoming_sessoion_txt">
                                                <div class="tab-pane fade <?= $indexClass; ?>" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                                    <?php if($model->is_admin_approve == 0) { ?>
                                                    <?php $form = ActiveForm::begin(); ?>
                                                    <?php
                                                        $redirect= Url::to(['user/details/'.$model->id ]);
                                                    echo $form->field($model, 'is_admin_approve')->widget(SwitchInput::classname(), [
                                                        'name' => 'is_admin_approve',
                                                        'pluginOptions' => [
                                                        'onText' => 'Approve',
                                                        'offText' => 'Reject'],
                                                        'labelOptions' => ['style' => 'font-size: 16px'],
                                                        'pluginEvents' => [
                                                            "switchChange.bootstrapSwitch" => 'function() { 
                                                            $.ajax({
                                                            method: "POST",
                                                            url: "' . Url::to(['/user/approve/' . $model->id]) . '",
                                                            data: { is_admin_approve: this.checked , id: ' . $model->id . '},
                                                            success: function(response){
                                                                Swal.fire({
                                                                    title: "Success!",
                                                                    type: "success",
                                                                    text: response.data.message,
                                                                    showCancelButton: false,
                                                                    confirmButtonColor: "#3085d6",
                                                                    cancelButtonColor: "#d33",
                                                                    confirmButtonText: "Continue"
                                                                        }).then((result) => {
                                                                        if (result.value) {
                                                                        window.location.href= "'.$redirect.'";
                                                                        }
                                                                    });

                                                            }
                                                            })
                                                        }',
                                                        ]
                                                    ])->label(false);
                                                    ActiveForm::end();
                                                    } ?>                       
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6"><span class="left">Full Name</span></div>
                                        <div class="col-md-6"><span class="right"><?php echo $model->first_name . " " . $model->last_name; ?></span></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6"><span class="left">Status</span></div>
                                        <div class="col-md-6"><span class="right">   
                                          <?= $model->getState($model->state_id); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6"><span class="left">Role</span></div>
                                        <div class="col-md-6"><span class="right"><?php echo empty($model->title) ? 'Not Set' : $model->title; ?></span></div>
                                   
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6"><span class="left">Date of Birth</span></div>
                                        <div class="col-md-6"><span class="right"><?php echo empty($model->age) ? 'Not Set' : $model->age; ?></span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6"><span class="left">Contact No.</span></div>
                                        <div class="col-md-6"><span class="right"><?php echo empty($model->contact_number) ? 'No Contact Found' : $model->contact_number; ?></span></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                  
                                        <div class="row">
                                            <div class="col-md-6"><span class="left">Approve Status</span></div>
                                            <div class="col-md-6"><span class="right badge-blue">
                                       
                                            <?=  $model->getApproveStatus($model->is_admin_approve); ?>
                
                                         
                                            </span></div>
                                        </div>
                                   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6"><span class="left"><strong>Email</strong></span></div>
                                        <div class="col-md-6"><span class="right"><?php echo $model->email; ?></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
													<!-- <ul>
													  <li><span>Tutor Name</span> Vani Ganesan</li>
													  <li><span>Session Name</span> <a href="#">Duis aute irure dolor <img  src="../assets/images/export.svg"> </a></li>
													  <li><span>Session Type</span> Education & Technology</li>
													  <li><span>Time</span> Start Time : 12:30 pm<br> End Time :01:30 pm</li>
													</ul> -->
												</div>
											</div>
										</div>

									


									</div>
								</div>	
								
							</div>

							<div class="row">
								<div class="col-md-12 col-sm-12 Dashboard_table">
									<div class="card">
										<div class="card-header">
											<div class="card-title">Scans</div>
										</div>
										<div class="card-body">
										 <div class="table-responsive">
                                         <?php
                                echo GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'columns' => [
                                        ['class' => 'kartik\grid\SerialColumn'],
                                        [
                                            'class' => 'kartik\grid\DataColumn', // can be omitted, as it is the default
                                            'label' => 'Created On',
                                            'value' => function ($data) {
                                                return Yii::$app->formatter->asDatetime($data->created_at); // 2014-10-06

                                            },
                                        ],
                                        [
                                            'class' => 'kartik\grid\DataColumn', // can be omitted, as it is the default
                                            'label' => 'Request',
                                            'value' => function ($data) {
                                                return StringHelper::truncate($data->process_value, 75);
                                            },
                                        ],
                                        [
                                            'class' => 'kartik\grid\DataColumn', // can be omitted, as it is the default
                                            'label' => 'Credits',

                                            'value' => function ($data) {
                                                return ($data->credit_used); // 2014-10-06

                                            },
                                        ],
                                        [
                                            'class' => 'kartik\grid\BooleanColumn',
                                            'label' => 'Status',
                                            'format' => 'html',
                                            'value' => function ($data) {
                                                return UserRecords::getState($data->state_id);
                                            },
                                        ],
                                        [
                                            'class' => 'yii\grid\ActionColumn',
                                            'template' => '{results}',
                                            'buttons' => [
                                                'results' => function ($url, $data) {
                                                    if ($data->state_id === 1) {
                                                        $url = Url::to(['scan/results/' . $data->process_id]);
                                                        return Html::a(
                                                            '<i class="fa fa-arrow-circle-o-right icon-text icon-text-xs fa-2x text-danger ml-auto pl-3"></i>',
                                                            $url,
                                                            [
                                                                'title' => 'View Records', 'target' => '_blank', 'data-pjax' => "0",
                                                            ]
                                                        );
                                                    } else {
                                                        $url = 'javascript:void(0)';
                                                        return Html::a(
                                                            '<i class="fa fa-ban icon-text icon-text-xs fa-2x text-muted ml-auto pl-3"></i>',
                                                            $url,
                                                            [
                                                                'title' => '',

                                                            ]
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
                                        'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link'],
                                    ],
                                    'tableOptions' => [
                                        'class' => 'table',
                                    ],
                                    'bootstrap' => false,
                                    'summary' => '',
                                ]);
                                ?>
											</div>
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
       

       
<div> <!--container -->