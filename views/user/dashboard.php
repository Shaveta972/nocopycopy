<?php

use yii\helpers\Url;
use yii\bootstrap\Html;
/* @var $this yii\web\View */
/* @var $model app\models\User */
use kartik\grid\GridView;
use app\models\UserRecords;
use yii\helpers\StringHelper;
use yii\widgets\Pjax;
use app\models\User;
$this->title = \Yii::t('app', 'View Dashboard');
\yii\web\YiiAsset::register($this);
echo \yii2mod\alert\Alert::widget();
?>

<div class="container">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="pb-2 fw-bold panel-header-heading">Dashboard</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner mt--5">
        <div class="row mt--2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Overall Statistics</div>
                    </div>
                    <div class="card-body">
						<div class="row">
							<div class="col-md-4 col-sm-4 text-center overall_statics">
                                <div id="circles-1"></div>
                             
									<h6>Total Scans Completed</h6>
								</div>
							<div class="col-md-4 col-sm-4 text-center overall_statics">
                                <?php echo Html::img('@web/themes/frontend/new_images/job-posted.svg', ['alt' => "job-posted"]) ?>
								<br>
								<span><?php echo $totalCredits; ?> credits</span>
								<h6>Total Credits Earned</h6>
							</div>
							<div class="col-md-4 col-sm-4 text-center overall_statics">
                                <?php echo Html::img('@web/themes/frontend/new_images/learing-hours.svg', ['alt' => "learing-hours"]) ?>
									<br>
								<span><?php echo $count_scans; ?></span>
								<h6>Total Scanned Files </h6>
								</div>
							</div>
						</div>
					</div>
                </div>

        <div class="row">      
            <div class="col-md-6 col-sm-6 wh_box">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Credits Statistics   
                    </div>
                </div>
                <div class="card-body">
                <div class="media border-bottom align-items-center p-3">
                    <div class="media-body mr-2">
                        <b class="text-bgray mr-2">User type: </b>
                        <span class="ml-auto "><?php echo $model->title; ?></span>
                    </div>
                    <div class="media-body mr-2">
                        <b class="text-bgray mr-2">Credit Account: </b>
                        <span class="ml-auto "><?php echo $model->getCreditAccountState($model->credit_type); ?></span>
                    </div>
                </div>
                <h5 class="card-header-credits p-3">Personal Credits <small class="text-muted">(Personal+ PlanCredits)</small></h5>
                    <?php if (Yii::$app->user->identity->parent_id == 0 && !empty(Yii::$app->user->identity->referal_code)) { ?>
                        <div class="row form-group">
                            <div class="col-md-6">
                                <div id="credits_log" class="gauge"></div>
                            </div>
                            <div class="col-md-5">
                                <ul class="list-group pt-3">
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 py-1">
                                        <span class="font-weight-normal"> Remaining Credits </span>
                                        <span class="badge badge-danger badge-pill "><?php echo $creditData['remainingCredits']; ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 py-1">
                                        Allocated Credits:
                                        <span class="badge badge-light badge-pill"><?php echo $creditData['allocatedCredits']; ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 py-1">
                                        Personal Usage
                                        <span class="badge badge-light badge-pill"> <?php echo (isset($creditData['selfUsedCredits']) && $creditData['selfUsedCredits'] > 0) ? $creditData['selfUsedCredits'] : 0; ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php if (!empty(Yii::$app->user->identity->referal_code)) { ?>
                            <script>
                                document.addEventListener("DOMContentLoaded", function(event) {
                                    var credits_log;
                                    var defs1 = {
                                        label: "Credits Used",
                                        value: <?php echo $creditData['totalCreditsUsed']; ?>,
                                        min: 0,
                                        max: <?php echo $creditData['totalCredits']; ?>,
                                        decimals: 0,
                                        gaugeWidthScale: 0.6,
                                        pointer: true,
                                        pointerOptions: {
                                            toplength: -15,
                                            bottomlength: 6,
                                            bottomwidth: 8,
                                            color: '#8e8e93',
                                            stroke: '#ffffff',
                                            stroke_width: 2,
                                            stroke_linecap: 'round'
                                        },
                                        counter: true,
                                        relativeGaugeSize: true
                                    }
                                    credits_log = new JustGage({
                                        id: "credits_log",
                                        defaults: defs1
                                    });
                                });
                            </script>
                        <?php } ?>
                        <?php } ?>
                        <?php if (Yii::$app->user->identity->parent_id ==0 && empty(Yii::$app->user->identity->referal_code)) { ?>
                            <div class="row">
                                <div class="col-md-6">
                                <div id="credits_freelancers_log" class="gauge"></div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", function(event) {
                                        var credits_freelancers_log;
                                        var defs1 = {
                                            label: "Credits Used",
                                            value: <?php echo (isset($pcredits_used) && $pcredits_used > 0) ? $pcredits_used : 0; ?>,
                                            min: 0,
                                            max: <?php echo $personal_credits; ?>,
                                            decimals: 0,
                                            gaugeWidthScale: 0.6,
                                            pointer: true,
                                            pointerOptions: {
                                                toplength: -15,
                                                bottomlength: 6,
                                                bottomwidth: 8,
                                                color: '#8e8e93',
                                                stroke: '#ffffff',
                                                stroke_width: 2,
                                                stroke_linecap: 'round'
                                            },
                                            counter: true,
                                            relativeGaugeSize: true
                                        }


                                        credits_freelancers_log = new JustGage({
                                            id: "credits_freelancers_log",
                                            defaults: defs1
                                        });
                                    });
                                </script>
                                </div>
                    
                                <div class="col-md-5">
                                    <ul class="list-group pt-3">
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 py-1">
                                            <span class="font-weight-normal"> Remaining Credits </span>
                                            <span class="badge badge-danger badge-pill ">  <?php echo (isset($remaining_personal_credits) && $remaining_personal_credits > 0) ? $remaining_personal_credits : 0; ?>
                                        </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        <?php }
                        ?>
                        <?php if (Yii::$app->user->identity->parent_id > 0) { ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="media pl-3 pb-3">
                                        <div class="media-body">
                                            <span class="d-block pb-1">Total<br></span>
                                            <span class="">
                                                <?php echo $personal_credits; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="media pl-3 pb-3">
                                        <div class="media-body">
                                            <span class="d-block pb-1">Used Count<br></span>
                                            <span class="">
                                                <?php echo (isset($pcredits_used) && $pcredits_used > 0) ? $pcredits_used : 0; ?> 
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="media pl-3 pb-3">
                                        <div class="media-body">
                                            <span class="d-block pb-1"> Remaining Count</span>
                                            <span class="">
                                                <?php echo (isset($remaining_personal_credits) && $remaining_personal_credits > 0) ? $remaining_personal_credits : 0; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h5 class="card-header-credits p-3">Allocated Credits Usage</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="media pl-3 pb-3">
                                        <div class="media-body">
                                            <span class="d-block pb-1">Total<br></span>
                                            <span class="">
                                                <?php echo Yii::$app->user->identity->allocated_credits; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="media pl-3 pb-3">
                                        <div class="media-body">
                                            <span class="d-block pb-1">Used Count<br></span>
                                            <span class="">
                                                <?php echo (isset($allocated_used_credits) && $allocated_used_credits > 0) ? $allocated_used_credits : 0; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="media pl-3 pb-3">
                                        <div class="media-body">
                                            <span class="d-block pb-1"> Remaining Count</span>
                                            <span class="">
                                                <?php echo (isset($remaining_business_credits) && $remaining_business_credits > 0) ? $remaining_business_credits : 0; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
             </div>	

                <!-- start plandetails -->
                <div class="col-md-6 wh_box">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Plan Details</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <b class="col-form-label">Plan Name:</b>
                                            <div class="form-control-plaintext">
                                                <?= isset($planmodel) ? $planmodel->plans->title : 'No Plan'; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <b class="col-form-label">Earned Credits:</b>
                                            <div class="form-control-plaintext">
                                                <?= isset($planmodel) ? $planmodel->plans->number_credits : '-'; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <b class="col-form-label">Expires on:</b>
                                            <div class="form-control-plaintext">
                                             <?= isset($planmodel) ? Yii::$app->formatter->asDate($planmodel->expiration_date, 'd-M-Y') : '-'; ?>
                                        </div>
                                    </div>
                                </div>
                                    <?php if (Yii::$app->user->identity->parent_id > 0) { ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <b class="col-form-label">Admin Used Credits Count</b>
                                                <div class="form-control-plaintext">
                                                    <?php echo (isset($admin_used_credits) && $admin_used_credits > 0) ? $admin_used_credits : 0; ?> </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                        <?php if (Yii::$app->user->identity->parent_id > 0) { ?>
                            <a href="<?php echo Url::to(['user/update', 'id' => $model->id]); ?>">
                                <i class="fa fa-edit icon-text icon-text-xs"></i> Click here to update your credit account
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
                        <!-- end plan detaos -->	



        </div>
  

                <div class="row">
                    <div class="col-md-12 col-sm-12 Dashboard_table">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="card-title">
                                    Your Scans
                                </div>
                                <button class="btn btn-blue" onclick="window.location = '<?php echo Url::to(['/site/front/']); ?>';"> New Scan
                                    <?php echo Html::img('@web/themes/frontend/new_images/Polygon2.svg', ['alt' => "Polygon2" , 'style'=> "height: 12px;"]) ?>
                                </button> 
                            </div>
                            <div class="card-body">
											<?php
												Pjax::begin(['id' => 'data-grid', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]); ?>
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
																'class' => 'kartik\grid\DataColumn', // can be omitted, as it is the default
																'label' => 'Request',
																'format' => 'raw',
																'value' => function ($data) {
																	return StringHelper::truncate($data->process_value, 75);
																},
															],
															[
																'attribute' => 'credit_used',
																'class' => 'kartik\grid\DataColumn', // can be omitted, as it is the default
																'label' => 'Credits Used'
															],
															[
																'attribute' => 'credit_type',
																'class' => 'kartik\grid\DataColumn', // can be omitted, as it is the default
																'label' => 'Credit Account',
																'value' => function ($data) {
																	return User::getCreditAccountState($data->credit_type);
																}
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
																'class' => 'kartik\grid\ActionColumn',
																'template' => '{results}',
																'buttons' => [
																	'results' => function ($url, $data) {
																		if ($data->state_id === 1) {
																			// $url = Url::to(['scan/results/' . $data->process_id]);
																			return Html::a(
																				'<i class="fa fa-arrow-circle-o-right icon-text icon-text-xs fa-2x text-danger ml-auto pl-3"></i>',
																				Url::to(['scan/results/' . $data->process_id]),
																				['title' => 'View Records', 'target' => '_blank', 'data-pjax' => "0"]
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
</div>







<?php
echo $this->registerJs(' 
    setInterval(function(){  
         $.pjax.reload({container:"#data-grid"});
    }, 80000);', \yii\web\VIEW::POS_HEAD);
?>
<?php
echo $this->registerJs("Circles.create({
    id:'circles-1',
    radius:45,
    value:60,
    maxValue:100,
    width:7,
    text:$count_scans,
    colors:['#DCE0E3', '#13337a '],
    duration:400,
    wrpClass:'circles-wrp',
    textClass:'circles-text',
    styleWrapper:true,
    styleText:true
    });", \yii\web\VIEW::POS_END);
?>
 