<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
echo \yii2mod\alert\Alert::widget();
?>
<div class="user-form plans">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-md-6 mx-auto">
            <?php $form = ActiveForm::begin(['id' => 'chnage-password-form',    'enableClientValidation' => true ]); ?>
            
                <div class="form-sign-inner">
                    <div class="media-body d-flex align-items-center mr-2 top_heading mb-3 border-bottom">
                        <h4>Change Password</h4>
                    </div>
                    <div class="form-row">
                        <?= $form->field($model, 'old_password', ['options' => ['class' => 'form-group col-md-12']])->passwordInput(['placeholder' => "Old Password"])->label(false) ?>
                        <?= $form->field($model, 'new_password', ['options' => ['class' => 'form-group col-md-12']])->passwordInput(['placeholder' => "New Password"])->label(false) ?>
                        <?= $form->field($model, 'confirm_password', ['options' => ['class' => 'form-group col-md-12']])->passwordInput(['placeholder' => "Confirm Password"])->label(false) ?>
                        <div class="form-group col-md-6 form-sign-button d-flex justify-content-between ">
                            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-main mr-2']) ?>

                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
