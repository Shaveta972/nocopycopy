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
							<div class="col-lg-6 col-md-6 col-sm-6 wk_form">
								<label for="name" >Address  <span class="required-label">*</span></label>
								<?= $form->field($model, 'address', ['options' => ['class' => '']])
								->textInput(['maxlength' => true, 'placeholder' => "Enter Address"])->label(false) ?>
								<!-- <input type="text" class="form-control" id="name" name="name" placeholder="Enter Location" required=""> -->
							</div> 
							<div class="col-lg-6 col-md-6 col-sm-6 wk_form">
								<label for="name" >Street Address  <span class="required-label"></span></label>
								<?= $form->field($model, 'street_address', ['options' => ['class' => '']])
								->textInput(['maxlength' => true, 'placeholder' => "Enter Street Address"])->label(false) ?>
								<!-- <input type="text" class="form-control" id="name" name="name" placeholder="Enter Street Address" required=""> -->
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 wk_form">
								<label>Country <span class="required-label">*</span></label>
								<?= $form->field($model, 'country', ['options' => ['class' => '']])
								->textInput(['maxlength' => true, 'placeholder' => "Enter Country"])->label(false) ?>
								
									<!-- <div class="select2-input">
										<select id="state" name="country" class="form-control" required>
											<option value="">Select Country</option>
											<optgroup label="Alaskan/Hawaiian Time Zone">
												<option value="AK">Alaska</option>
												<option value="HI">Hawaii</option>
											</optgroup>
											<optgroup label="Pacific Time Zone">
												<option value="CA">California</option>
												<option value="NV" >Nevada</option>
												<option value="OR">Oregon</option>
												<option value="WA">Washington</option>
											</optgroup>
											<optgroup label="Mountain Time Zone">
												<option value="AZ">Arizona</option>
												<option value="CO">Colorado</option>
												<option value="ID">Idaho</option>
												<option value="MT">Montana</option>
												<option value="NE">Nebraska</option>
												<option value="NM">New Mexico</option>
												<option value="ND">North Dakota</option>
												<option value="UT">Utah</option>
												<option value="WY">Wyoming</option>
											</optgroup>
											<optgroup label="Central Time Zone">
												<option value="AL">Alabama</option>
												<option value="AR">Arkansas</option>
												<option value="IL">Illinois</option>
												<option value="IA">Iowa</option>
												<option value="KS">Kansas</option>
												<option value="KY">Kentucky</option>
												<option value="LA">Louisiana</option>
												<option value="MN">Minnesota</option>
												<option value="MS">Mississippi</option>
												<option value="MO">Missouri</option>
												<option value="OK">Oklahoma</option>
												<option value="SD">South Dakota</option>
												<option value="TX">Texas</option>
												<option value="TN">Tennessee</option>
												<option value="WI">Wisconsin</option>
											</optgroup>
											<optgroup label="Eastern Time Zone">
												<option value="CT">Connecticut</option>
												<option value="DE">Delaware</option>
												<option value="FL">Florida</option>
												<option value="GA">Georgia</option>
												<option value="IN">Indiana</option>
												<option value="ME">Maine</option>
												<option value="MD">Maryland</option>
												<option value="MA">Massachusetts</option>
												<option value="MI">Michigan</option>
												<option value="NH">New Hampshire</option>
												<option value="NJ">New Jersey</option>
												<option value="NY">New York</option>
												<option value="NC">North Carolina</option>
												<option value="OH">Ohio</option>
												<option value="PA">Pennsylvania</option>
												<option value="RI">Rhode Island</option>
												<option value="SC">South Carolina</option>
												<option value="VT">Vermont</option>
												<option value="VA">Virginia</option>
												<option value="WV">West Virginia</option>
											</optgroup>
										</select>
									</div> -->
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 wk_form">
								<label for="state" >State <span class="required-label">*</span></label>
								<?= $form->field($model, 'state', ['options' => ['class' => '']])
								->textInput(['maxlength' => true, 'placeholder' => "Enter state"])->label(false) ?>
									<!-- <div class="select2-input">
										<select id="state" name="state" class="form-control" required>
											<option value="">Select State</option>
											<optgroup label="Alaskan/Hawaiian Time Zone">
												<option value="AK">Alaska</option>
												<option value="HI">Hawaii</option>
											</optgroup>
											<optgroup label="Pacific Time Zone">
												<option value="CA">California</option>
												<option value="NV" >Nevada</option>
												<option value="OR">Oregon</option>
												<option value="WA">Washington</option>
											</optgroup>
											<optgroup label="Mountain Time Zone">
												<option value="AZ">Arizona</option>
												<option value="CO">Colorado</option>
												<option value="ID">Idaho</option>
												<option value="MT">Montana</option>
												<option value="NE">Nebraska</option>
												<option value="NM">New Mexico</option>
												<option value="ND">North Dakota</option>
												<option value="UT">Utah</option>
												<option value="WY">Wyoming</option>
											</optgroup>
											<optgroup label="Central Time Zone">
												<option value="AL">Alabama</option>
												<option value="AR">Arkansas</option>
												<option value="IL">Illinois</option>
												<option value="IA">Iowa</option>
												<option value="KS">Kansas</option>
												<option value="KY">Kentucky</option>
												<option value="LA">Louisiana</option>
												<option value="MN">Minnesota</option>
												<option value="MS">Mississippi</option>
												<option value="MO">Missouri</option>
												<option value="OK">Oklahoma</option>
												<option value="SD">South Dakota</option>
												<option value="TX">Texas</option>
												<option value="TN">Tennessee</option>
												<option value="WI">Wisconsin</option>
											</optgroup>
											<optgroup label="Eastern Time Zone">
												<option value="CT">Connecticut</option>
												<option value="DE">Delaware</option>
												<option value="FL">Florida</option>
												<option value="GA">Georgia</option>
												<option value="IN">Indiana</option>
												<option value="ME">Maine</option>
												<option value="MD">Maryland</option>
												<option value="MA">Massachusetts</option>
												<option value="MI">Michigan</option>
												<option value="NH">New Hampshire</option>
												<option value="NJ">New Jersey</option>
												<option value="NY">New York</option>
												<option value="NC">North Carolina</option>
												<option value="OH">Ohio</option>
												<option value="PA">Pennsylvania</option>
												<option value="RI">Rhode Island</option>
												<option value="SC">South Carolina</option>
												<option value="VT">Vermont</option>
												<option value="VA">Virginia</option>
												<option value="WV">West Virginia</option>
											</optgroup>
										</select>
									</div> -->
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 wk_form">
								<label for="name" >City <span class="required-label">*</span></label>
							
								<?= $form->field($model, 'city', ['options' => ['class' => '']])
								->textInput(['maxlength' => true, 'placeholder' => "Enter city"])->label(false) ?>
								<!-- <div class="select2-input">
									<select id="state" name="city" class="form-control" required>
										<option value="">Select City</option>
										<optgroup label="Alaskan/Hawaiian Time Zone">
											<option value="AK">Alaska</option>
											<option value="HI">Hawaii</option>
										</optgroup>
										<optgroup label="Pacific Time Zone">
											<option value="CA">California</option>
											<option value="NV" >Nevada</option>
											<option value="OR">Oregon</option>
											<option value="WA">Washington</option>
										</optgroup>
										<optgroup label="Mountain Time Zone">
											<option value="AZ">Arizona</option>
											<option value="CO">Colorado</option>
											<option value="ID">Idaho</option>
											<option value="MT">Montana</option>
											<option value="NE">Nebraska</option>
											<option value="NM">New Mexico</option>
											<option value="ND">North Dakota</option>
											<option value="UT">Utah</option>
											<option value="WY">Wyoming</option>
										</optgroup>
										<optgroup label="Central Time Zone">
											<option value="AL">Alabama</option>
											<option value="AR">Arkansas</option>
											<option value="IL">Illinois</option>
											<option value="IA">Iowa</option>
											<option value="KS">Kansas</option>
											<option value="KY">Kentucky</option>
											<option value="LA">Louisiana</option>
											<option value="MN">Minnesota</option>
											<option value="MS">Mississippi</option>
											<option value="MO">Missouri</option>
											<option value="OK">Oklahoma</option>
											<option value="SD">South Dakota</option>
											<option value="TX">Texas</option>
											<option value="TN">Tennessee</option>
											<option value="WI">Wisconsin</option>
										</optgroup>
										<optgroup label="Eastern Time Zone">
											<option value="CT">Connecticut</option>
											<option value="DE">Delaware</option>
											<option value="FL">Florida</option>
											<option value="GA">Georgia</option>
											<option value="IN">Indiana</option>
											<option value="ME">Maine</option>
											<option value="MD">Maryland</option>
											<option value="MA">Massachusetts</option>
											<option value="MI">Michigan</option>
											<option value="NH">New Hampshire</option>
											<option value="NJ">New Jersey</option>
											<option value="NY">New York</option>
											<option value="NC">North Carolina</option>
											<option value="OH">Ohio</option>
											<option value="PA">Pennsylvania</option>
											<option value="RI">Rhode Island</option>
											<option value="SC">South Carolina</option>
											<option value="VT">Vermont</option>
											<option value="VA">Virginia</option>
											<option value="WV">West Virginia</option>
										</optgroup>
									</select>
								</div> -->
							</div>
							
							<div class="col-lg-6 col-md-6 col-sm-6 wk_form">
								<label for="name" >Postal / Zip Code <span class="required-label">*</span></label>
								
								<?= $form->field($model, 'zipcode', ['options' => ['class' => '']])
								->textInput(['maxlength' => true, 'placeholder' => "Enter Zipcode"])->label(false) ?>
								<!-- <input type="text" class="form-control" id="name" name="zipcode" placeholder="Enter Code" required=""> -->
							</div>
						
						
							<div class="col-lg-12 col-md-12 col-sm-12 wk-form mb-3">
							<?= $form->field($model, 'profile_picture', ['options' => ['class' => 'form-group col-md-12']])->fileInput()->label(false) ?>
							<?php 
							// echo $form->field($model, 'profile_picture[]')->widget(FileInput::classname(), 
							// [
							// 		'options' => ['multiple' => false, 'accept' => 'image/*'],
							// 		'pluginOptions' => ['previewFileType' => 'image',
							// 		'showUpload' => false,
							// 		'showPreview' => false],
									
							// 	]);
								?>
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

		
	