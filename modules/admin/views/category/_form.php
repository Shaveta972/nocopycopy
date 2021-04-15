<?php

use yii\helpers\Html;
use app\widgets\ActiveForm;
use app\widgets\PageHeader;
/* @var $this yii\web\View */
/* @var $model app\models\UserCategories */
/* @var $form yii\widgets\ActiveForm */

?>
	<?= PageHeader::widget([
    	'title'=> 'Update Category'
    ]) ?>
<div class="user-categories-form box box-primary">
	<div class="box-header with-border">
    <?php $form = ActiveForm::begin(); ?>
		<div class="box-body">
		<div class="row">
		<div class="col-md-6">
    <?= $form->field($model, 'category_type')->dropDownList([ 'Individual' => 'Individual', 'Education' => 'Education', 'Business' => 'Business', '' => '', ], ['prompt' => '']) ?>

		<?= $form->field($model, 'category_name')->textInput(['maxlength' => true])->label('Alias Name') ?>

	</div>
	</div>
		</div>
    <div class="box-footer">
    	<div class="row">
    		<div class="col-md-6">
    			 <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>	
    		</div>
    	</div>       
    </div>

    <?php ActiveForm::end(); ?>
	</div>
</div>
