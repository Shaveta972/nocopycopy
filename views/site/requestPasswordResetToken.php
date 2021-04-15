<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Request password reset';
?>
<div class="forgotpw signup-page signup-blue">
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
                            <div class="site-request-password-reset">
                                <?php
                                $form = ActiveForm::begin(['options' => ['class' => 'form-sign', 'id' => 'request-password-reset-form']]);
                                ?>
                                <div class="form-sign-inner">
                                <div class="text-center mb-4">
                                      <div class="theme-heading mb-3">
                                          <h5>Reset Password</h5>
                                      </div>
                                    <p class="text-muted mb-0 font-13">Enter your email address and we'll send you an email with instructions to reset your password.  </p>
                                </div>
                                    <div class="form-row">
                                        <?php
                                     echo $form->field($model, 'email', [
                                         'options' => ['class' => 'form-group col-md-12 mb-0'],
                                         'template' => '{input}{hint}{error}'])->textInput([
                                         'placeholder' => "Email"
                                     ]);
                                     ?>
                                        <div class="form-sign-button col-md-12 pt-0">
                                            <button type="submit" class="btn-main w-100">Send</button>
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