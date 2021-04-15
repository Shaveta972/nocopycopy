<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\password\PasswordInput;
echo \yii2mod\alert\Alert::widget();
?>

<div class="container">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="pb-2 fw-bold panel-header-heading">Account Settings</h2>
                </div>
            </div>
        </div>
    </div>
<div class="page-inner mt--5">
    <div class="row mt--2">
        <div class="col-md-12">
            <div class="card full-height">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 col-sm-10	form_box">
                            <h4 class="card-heading">Change Password</h4>
                            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-group form-show-validation row']]) ?>
                                <div class="col-lg-4 col-md-4 col-sm-6 wk_form">
                                    <label >Current Password <span class="required-label">*</span></label>
                                    <?= $form->field(
                                        $changePasswordModel,
                                        'old_password',
                                        ['options' => ['class' => '']])
                                        ->passwordInput(['placeholder' => "Old Password"])
                                        ->label(false); ?>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 wk_form">
                                    <label>New Password  <span class="required-label">*</span></label>
                                        <?= $form->field($changePasswordModel, 'new_password', [
                                            'options' => [
                                            'class' => 'form-group col-md-12'],
                                            'template' => '{input}{hint}{error}'
                                            ])->widget(PasswordInput::classname(), [
                                            'pluginOptions' => [
                                            'showMeter' => false,
                                            'toggleMask' => false
                                        ]
                                    ])->passwordInput([
                                        'placeholder' => 'New Password'
                                    ]); ?>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 wk_form">
                                        <label>Re-enter New Password <span class="required-label">*</span></label>
                                        <?= $form->field($changePasswordModel, 'confirm_password', [
                                            'options' => ['class' => 'form-group col-md-12'],
                                            'template' => '{input}{hint}{error}',
                                            ])->widget(PasswordInput::classname(), [
                                        'pluginOptions' => [
                                            'showMeter' => false,
                                            'toggleMask' => false]])->passwordInput(['placeholder' => 'Re-enter password']); ?>
                                </div>
                                <div class="col-md-12 ">
                                    <?= Html::submitButton(Yii::t('app', 'Save Password'), ['class' => 'btn btn-primary']) ?>
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
