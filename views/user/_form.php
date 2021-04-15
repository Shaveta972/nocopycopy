<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Modal;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

// or 'use kartikile\FileInput' if you have only installed yii2-widget-fileinput in isolation
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="container">
	<div class="panel-header bg-primary-gradient">
		<div class="page-inner py-5">
			<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
				<div>
					<h2 class="pb-2 fw-bold panel-header-heading">Manage Profile</h2>
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
						
							<div class="col-md-12 col-sm-12	form_box">
								<h4 class="card-heading">Basic information</h4>
					
								<?php $form = ActiveForm::begin(['options' => ['class' => 'form-group form-show-validation row', 'enctype' => 'multipart/form-data']]) ?>
								<div class="col-lg-12 col-md-12 col-sm-12 wk_form">
							    <?php
							        if (Yii::$app->user->identity->parent_id == 0) {
							            echo '<label for="name" >Business Name <span class="required-label">*</span></label>';
							            if (!empty(Yii::$app->user->identity->business_name)) {
							                echo $form->field($model, 'business_name', ['options' => ['class' => 'form-group col-md-12','id' =>'business_input'],'template' => '{input}{hint}{error}'])->textInput(['placeholder' => 'Business Name' ]);
							            } elseif (!empty(Yii::$app->user->identity->school_name)) {
							                echo '<label for="name" >Institution/School/University Name <span class="required-label">*</span></label>';
							                echo $form->field($model, 'school_name', ['options' => [ 'class' => 'form-group col-md-12','id' => 'education_input'],'template' => '{input}{hint}{error}'])->textInput(['placeholder' => 'University/School Name']);
							            }
							        }
									?>
							</div>
                    
							<div class="col-lg-4 col-md-4 col-sm-6 wk_form">
								<label for="name" >First Name <span class="required-label">*</span></label>
								<?= $form->field($model, 'first_name', ['options' => ['class' => 'form-group col-md-12']])->textInput(['maxlength' => true, 'placeholder' => "First Name"])->label(false) ?>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-6 wk_form">
								<label for="name" >Last Name <span class="required-label">*</span></label>
								<?= $form->field($model, 'last_name', ['options' => ['class' => 'form-group col-md-12']])->textInput(['maxlength' => true, 'placeholder' => "Last Name"])->label(false) ?>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-6 wk_form">
								<label for="name" >Email Address <span class="required-label">*</span></label>
								<?= $form->field($model, 'email', ['options' => ['class' => '']])->textInput(['maxlength' => true, 'placeholder' => "Enter Email"])->label(false) ?>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-6 wk_form">
								<label>Gender <span class="required-label">*</span></label>
								<select class="form-control" id="exampleFormControlSelect1">
									<option>Select</option>
									<option>Male</option>
									<option>Female</option>
								</select>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-6 wk_form">
								<label for="name" >Phone No <span class="required-label">*</span></label>
								<?= $form->field($model, 'contact_number', ['options' => ['class' => '']])->textInput(['maxlength' => true, 'placeholder' => "Enter Phone No"])->label(false) ?>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-6 wk_form">
								<label for="name" >Date Of Birth  <span class="required-label">*</span></label>
								<?= $form->field($model, 'age', ['options' => ['class' => '']])
								->widget(DatePicker::classname(), [
								'options' => ['placeholder' => 'D.O.B'],
								'pluginOptions' => [
									'autoclose' => true,
									'format' => 'mm/dd/yyyy'
								]])->label(false);
								?>
							</div>
							</div>
					
							<div class="col-lg-12 col-md-12 col-sm-12 wk-form mb-3">
							<?= $form->field($model, 'profile_picture', ['options' => ['class' => 'form-group col-md-12']])->fileInput()->label(false) ?>
						</div>


							<?php if ( Yii::$app->user->identity->parent_id > 0) { ?>
							<div class="col-lg-6 col-md-6 col-sm-6 wk_form">
							<?= $form->field($model, 'credit_type', ['options' => ['class' => 'form-control mb-0']])->dropDownList(['1' => 'Personal', '3' => 'Allocated',], ['prompt' => 'Select Credit Account'])->label(false) ?>
							</div>
							<?php } ?>

							<div class="col-md-12">
							<?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
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

		
	