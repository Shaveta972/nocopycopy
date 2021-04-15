<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\authclient\widgets\AuthChoice;
/* @var $this yii\web\View */
/* @var $model app\models\LoginForm */
/* @var $form ActiveForm */

echo \yii2mod\alert\Alert::widget();
$this->title = \Yii::t('app', 'Login');
?>
<div class="signup-page signup-blue">
    <div class="container h-100">
        <div class="row no-gutters h-100">
            <div class="col-md-8 h-100">
                <div class="h-100">
                    <div class="row align-items-center h-100">
                        <div class="col-md-6">
                            <div class="signup-text text-white">
                                <h6>Login Now!</h6>
                                <h1><strong> Authenticity,</strong> <span>Request Early Access.</span></h1>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="UserLogin">
                                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-sign ']]); ?>
                                <div class="form-sign-inner">
                                    <div class="theme-heading mb-3">
                                        <h5>Account Login</h5>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-12 position-relative">
                                            <?= $form->field($model, 'email', ['options' => ['class' => 'form-group col-md-12'], 'template' => '{input}{hint}{error}'])->textInput(['placeholder' => 'Email']);
                                            ?>
                                        </div>
                                        <div class="col-12 position-relative">
                                            <?= $form->field($model, 'password', ['options' => ['class' => 'form-group col-md-12'], 'template' => '{input}{hint}{error}'])->passwordInput(['placeholder' => "Password",]);
                                            ?>
                                        </div>
                                        <div class="col-md-12">
                                            <?= Html::submitButton('Authenticate', ['class' => 'btn btn-main w-100']) ?>
                                        </div>
                                        <?= $form->field($model, 'rememberMe', ['options' => ['class' => 'form-group col-md-6 ']])->checkbox(['id' => 'remember-me-ver', 'custom' => true]) ?>
                                        <div class="form-group col-md-6  text-right ">
                                            <?= Html::a('Forgot Password?', ['site/request-password-reset'], ['class' => 'text-bgray register-link-color']) ?>
                                        </div>
                                        <div class="social_links">
                                            <?php
                                            $authAuthChoice = AuthChoice::begin(['baseAuthUrl' => ['site/auth'], 'popupMode' => false]);
                                            ?>
                                            <ul class="social-buttons d-flex justify-content-center">
                                                <?php foreach ($authAuthChoice->getClients() as $client) : ?>
                                                    <li><?= $authAuthChoice->clientLink($client) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                            <?php AuthChoice::end();
                                            ?>
                                        </div>
                                    </div>
                                    <div class="register-div d-flex justify-content-center">Not a member yet?
                                        <?= Html::a('Register now', ['site/register'], ['class' => 'text-bgray register-link-color ml-1']) ?>
                                    </div>
                                </div>
                                <?php ActiveForm::end(); ?>
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
    