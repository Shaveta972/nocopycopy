<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\password\PasswordInput;
$this->title = 'Reset password';
?>

<div class="signup-page signup-blue">
    <div class="container h-100">
        <div class="row no-gutters h-100">
            <div class="col-md-8 h-100">
                <div class="h-100">
                    <div class="row align-items-center h-100">
                        <div class="col-md-6">
                            <div class="signup-text text-white">
                                <h6>Reset Password Now!</h6>
                                <h1><strong> Authenticity,</strong> <span>Request Early Access.</span></h1>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="site-reset-password">
                                <?php
                                $form = ActiveForm::begin(['options' => ['class' => 'form-sign', 'id' => 'reset-password-form']]);
                                ?>
                                <div class="form-sign-inner">
                                    <div class="theme-heading mb-3">
                                        <h5>Enter New Password</h5>
                                    </div>
                                    <div class="form-row">
                                    <?php
                                    echo $form->field($model, 'password', [
                                        'options' => [
                                            'class' => 'form-group col-md-12 mb-0'
                                        ],
                                        'template' => '{input}{hint}{error}'
                                    ])->widget(PasswordInput::classname(), [
                                        'pluginOptions' => [
                                            'showMeter' => false,
                                            'toggleMask' => false,
                                         
                                        ],
                                    ])->passwordInput([
                                        'placeholder' => 'New Password'
                                    ]) ?>
                                 

                                        <div class="form-sign-button col-md-12 pt-0">
                                            <button type="submit" class="btn-main w-100">Save</button>
                                        </div>

                                    </div>
                                </div>
                                <?php
                                ActiveForm::end();
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 position-img">
                <div class="signup-img">
                    <?php echo Html::img('@web/themes/frontend/images/sign-img.jpg', ['alt' => "sign-up"]); ?>
                </div>
            </div>
        </div>
    </div>
</div>