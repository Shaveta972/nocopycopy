<?php
/* @var $this yii\web\View */
/* @var $model app\models\User */
use app\widgets\ActiveForm;
$this->title = \Yii::t('app', 'View Profile');
\yii\web\YiiAsset::register($this);
echo \yii2mod\alert\Alert::widget();
?>

<div class="profile dashboard  user-view mt-1">
    <div class="container">
        <div class="jumbotron jumbotron-fluid pt-4 pb-3 bg-white">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="media  align-items-center">
                            <div class="media-body top_heading">
                                <h4 class=" align-center text-capitalize  text-body"> Order Summary</h4>
                            </div>


                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="card">
                                <h5 class="card-header h5">Your Details</h5>

                                <div class="media border-bottom align-items-center px-4 py-3">
                                    <div class="media-body d-flex align-items-center mr-2">
                                        <span class="text-bgray">Firstname</span>
                                        <span class="ml-auto text-info"><?php echo $usermodel->first_name; ?></span>
                                    </div>
                                    <i class="fa fa-user icon-text icon-text-xs d-flex text-success ml-auto pl-3"></i>
                                </div>
                                <div class="media border-bottom align-items-center px-4 py-3">
                                    <div class="media-body d-flex align-items-center mr-2">
                                        <span class="text-bgray">Lastname</span>
                                        <span class="ml-auto text-info"><?php echo $usermodel->last_name; ?></span>
                                    </div>
                                    <i class="fa fa-user icon-text icon-text-xs d-flex text-success ml-auto pl-3"></i>
                                </div>
                                <div class="media border-bottom align-items-center px-4 py-3">
                                    <div class="media-body d-flex align-items-center mr-2">
                                        <span class="text-bgray">Email</span>
                                        <span class="ml-auto text-info user-address"><?php echo empty($usermodel->email) ? 'Not Set' : $usermodel->email; ?></span>
                                    </div>
                                    <i class="fa fa-check icon-text icon-text-xs d-flex text-info ml-auto pl-3"></i>
                                </div>

                                <div class="media border-bottom align-items-center px-4 py-3">
                                    <div class="media-body d-flex align-items-center mr-2">
                                        <span class="text-bgray">Contact Number</span>
                                        <span class="ml-auto text-info user-address"><?php echo empty($usermodel->contact_number) ? 'Not Set' : $usermodel->contact_number; ?></span>
                                    </div>
                                    <i class="fa fa-check icon-text icon-text-xs d-flex text-info ml-auto pl-3"></i>
                                </div>



                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                            <?php $form=ActiveForm::begin(); ?>
                                <h5 class="card-header h5">Order Details</h5>
                                <div class="media border-bottom align-items-center px-4 py-3">
                                    <div class="media-body d-flex align-items-center mr-2">
                                        <span class="text-bgray">Plan Name</span>
                                        <span class="ml-auto text-info"><?= $planModel->title; ?></span>
                                    </div>
                                </div>
                                <div class="media border-bottom align-items-center px-4 py-3">
                                    <div class="media-body d-flex align-items-center mr-2">
                                        <span class="text-bgray">Validity</span>
                                        <span class="ml-auto text-info"><?= $planModel->validity; ?> month(s)</span>
                                    </div>
                                </div>
                                <div class="media border-bottom align-items-center px-4 py-3">
                                    <div class="media-body d-flex align-items-center mr-2">
                                        <span class="text-bgray">Credits</span>
                                        <span class="ml-auto text-info"><?= $planModel->number_credits; ?></span>
                                    </div>
                                </div>
                                <div class="media border-bottom align-items-center px-4 py-3">
                                    <div class="media-body d-flex align-items-center mr-2">
                                        <span class="text-bgray">Total Price</span>
                                        <span class="ml-auto text-info"><?= $planModel->price; ?> <?= $planModel->currency; ?></span>
                                    </div>
                                </div>
                                <?php echo $form->field($model, 'plan_id')->hiddenInput(['value' => $planModel->id])->label(false); ?>
                                <?php echo $form->field($model, 'user_id')->hiddenInput(['value' => $usermodel->id])->label(false); ?>
                             
                                <div class="row d-flex align-items-center mx-2 my-2 justify-content-center">
                                    <div class="media px-4 py-3">
                                        <div class="media-body">
                                            <button type="submit"  class='btn btn-md btn-blue pl-4 pr-4 pt-2 pb-2'>Make Payment</button>
                                        </div>

                                    </div>
                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>