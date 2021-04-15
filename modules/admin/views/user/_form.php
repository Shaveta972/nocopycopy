<?php

use yii\helpers\Html;
use app\widgets\ActiveForm;
use app\widgets\PageHeader;
/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

?>
	<?= PageHeader::widget([
    	'title'=>$this->title,
    ]) ?>
<div class="user-form box box-primary">
	<div class="box-header with-border">
    <?php $form = ActiveForm::begin(); ?>
		<div class="box-body">
		<div class="row">
		<div class="col-md-6">
    <?= $form->field($model, 'first_name')->textInput(['placeholder' => 'Firstname','maxlength' => true]) ?>
      <?= $form->field($model, 'last_name')->textInput(['placeholder' => 'Lastname','maxlength' => true]) ?>
			<?= $form->field($model, 'contact_number')->textInput(['placeholder' => 'Contact Number'])->label('Contact Number') ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
		<?= $form->field($model, 'confirmPassword')->passwordInput(['maxlength' => true]) ?>
		<?= $form->field($model, 'user_category_id')->dropDownList( $listData,['prompt' => 'Select Role']); ?>
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
