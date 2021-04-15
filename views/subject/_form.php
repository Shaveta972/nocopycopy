<?php

use yii\helpers\Html;
use app\widgets\ActiveForm;
use app\widgets\PageHeader;
/* @var $this yii\web\View */
/* @var $model app\models\Subjects */
/* @var $form yii\widgets\ActiveForm */

?>
	<?= PageHeader::widget([
    	'title'=>$this->title,
	]) ?>
	

	<div class="container">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="pb-2 fw-bold panel-header-heading">Add New Subject</h2>
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
                            <!-- <h4 class="card-heading">Add New Subject</h4> -->
                            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-group form-show-validation row']]) ?>
                                <div class="col-lg-4 col-md-4 col-sm-6 wk_form">
                                    <!-- <label >Current Password <span class="required-label">*</span></label> -->
									<?= $form->field($model, 'subject_name')->textInput(['maxlength' => true]) ?>
								
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 wk_form">
                                    <!-- <label>New Password  <span class="required-label">*</span></label> -->
									<?= $form->field($model, 'subject_code')->textInput(['maxlength' => true]) ?>	
                                </div>
                               
                                <div class="col-md-12 ">
                                    <?= Html::submitButton(Yii::t('app', 'Save Subject'), ['class' => 'btn btn-primary']) ?>
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





