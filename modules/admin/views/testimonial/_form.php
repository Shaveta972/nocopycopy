<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Testimonials */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="testimonials-form">
    <?php $form = ActiveForm::begin(['options' => ['class' => '', 'enctype' => 'multipart/form-data']]) ?>
    <?= $form->field($model, 'testimonials_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'testimonials_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'testimonials_name')->textInput(['rows' => 6]) ?>

    <?= $form->field($model, 'testimonials_image')->fileInput() ?>


    <?= $form->field($model, 'testimonials_html_text')->textarea(['rows' => 6]) ?>



    <?= $form->field($model, 'testimonials_country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->dropDownList(['1' => 'Active', '0' => 'InActive'],['prompt'=>'Select Option']); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
