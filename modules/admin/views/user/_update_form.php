<?php
use yii\helpers\Html;
use app\widgets\ActiveForm;
use app\widgets\PageHeader;
use app\models\User;
/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

?>
	<?=PageHeader::widget ( [ 'title' => 'Update User' ] )?>
<div class="user-form box box-primary">
	<div class="box-header with-border">
    <?php $form = ActiveForm::begin(); ?>
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
		<?= $form->field($model, 'email')->textInput(['maxlength' => true,'readonly'=> true]) ?>
		<?= $form->field($model, 'contact_number')->textInput(['placeholder' => 'Contact Number'])->label('Contact Number') ?>
		<?= $form->field($model, 'state_id')->dropDownList( User::getStateOptions($model->state_id),['prompt' => 'Set User State']); ?>
		<?= $form->field($model, 'is_admin_approve')->dropDownList( User::getApproveStatusOptions($model->is_admin_approve))->label('Approve User'); ?>
	
	</div>
			</div>
		</div>
		<div class="box-footer">
			<div class="row">
				<div class="col-md-6">
    			 <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>	
    		</div>
			</div>
		</div>

    <?php ActiveForm::end(); ?>
	</div>
</div>
