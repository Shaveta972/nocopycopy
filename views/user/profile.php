    <?php

    use yii\helpers\Url;
    use yii\bootstrap\Html;
    use kartik\grid\GridView;
    use yii\widgets\ActiveForm;
    use kartik\password\PasswordInput;
    use app\models\User;
    use yii\helpers\StringHelper;
    use app\models\UserRecords;
    use yii\widgets\Pjax;

    $this->title = \Yii::t('app', 'View Profile');
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
                        <h2 class="pb-2 fw-bold panel-header-heading">Profile</h2>
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
                                            <div class="row mb-3">
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6"><span class="left font-weight-bold">Role</span></div>
                                                        <div class="col-md-6"><span class="right custom-role-badge"><?php echo $model->title; ?></span></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6"><span class="left font-weight-bold">Email</span></div>
                                                        <div class="col-md-6"><span class="right"><?php echo $model->email; ?></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6"><span class="left font-weight-bold">Full Name</span></div>
                                                        <div class="col-md-6"><span class="right"><?= ucwords($model->first_name . " " . $model->last_name); ?></span></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6"><span class="left font-weight-bold">Date Of Birth</span></div>
                                                        <div class="col-md-6"><span class="right"><?php echo empty($model->age) ? 'Not Set' : $model->age; ?></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6"><span class="left font-weight-bold">Status</span></div>
                                                        <div class="col-md-6"><span class="right"><?php echo "Active"; ?></span></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6"><span class="left font-weight-bold">Contact No.</span></div>
                                                        <div class="col-md-6"><span class="right"><?php echo empty($model->contact_number) ? 'No Contact Found' : $model->contact_number; ?></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="row mb-3">
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6"><span class="left font-weight-bold">Address</span></div>
                                                        <div class="col-md-6"><span class="right"><?php //echo empty($model->address) ? 'No Address Found' : $model->address; ?></span></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6"><span class="left font-weight-bold">Street Address</span></div>
                                                        <div class="col-md-6"><span class="right"><?php //echo empty($model->street_address) ? 'No Street Address Found' : $model->street_address; ?></span></div>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <div class="row mb-3">
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6"><span class="left font-weight-bold">Country</span></div>
                                                        <div class="col-md-6"><span class="right"><?php //echo empty($model->country) ? 'No Country Found' : $model->country; ?></span></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6"><span class="left font-weight-bold">State</span></div>
                                                        <div class="col-md-6"><span class="right"><?php //echo empty($model->state) ? 'No State Found' : $model->state; ?></span></div>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <div class="row mb-3">
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6"><span class="left font-weight-bold">City</span></div>
                                                        <div class="col-md-6"><span class="right"><?php //echo empty($model->city) ? 'No City Found' : $model->city; ?></span></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6"><span class="left font-weight-bold">Postal Code</span></div>
                                                        <div class="col-md-6"><span class="right"><?php //echo empty($model->zipcode) ? 'No ZipCode Found' : $model->zipcode; ?></span></div>
                                                    </div>
                                                </div>
                                            </div> -->
                                    <div class="row mb-3">
                                        <div class="col-lg-6 col-md-12">
                                            <?php if ($model->parent_id == 0 && $model->referal_code) { ?>
                                                <div class="row">
                                                    <div class="col-md-6"><span class="left font-weight-bold">Referal Code</span></div>
                                                    <div class="col-md-6"><span class="right"><?php echo $model->referal_code; ?></span></div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                            <?php if (!empty($model->business_name)) { ?>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-6"><span class="left font-weight-bold">Business Name</span></div>
                                                        <div class="col-md-6"><span class="right"><?php echo $model->business_name; ?></span></div>
                                                    </div>
                                                </div>

                                            <?php } elseif (!empty($model->school_name)) { ?>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6"><span class="left font-weight-bold">School/University Name</span></div>
                                                        <div class="col-md-6"><span class="right"><?php echo $model->school_name; ?></span></div>
                                                    </div>
                                                </div>
                                                <?php } else {
                                                    $data = '';
                                                }
                                                ?>
                                        </div>                                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>	
                </div>
            </div>
        </div>
    </div>
<div> <!--container -->
