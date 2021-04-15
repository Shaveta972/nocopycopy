<?php

use yii\helpers\Html;
use app\widgets\ActiveForm;
use app\widgets\PageHeader;
/* @var $this yii\web\View */
/* @var $model app\models\Plans */
/* @var $form yii\widgets\ActiveForm */

?>
	<?= PageHeader::widget([
    	'title'=>$this->title,
    ]) ?>
<div class="plans-form box box-primary">
	<div class="box-header with-border">
    <?php $form = ActiveForm::begin(); ?>
		<div class="box-body">
		<div class="row">
		<div class="col-md-8">
	<?= $form->field($model, 'user_category_id', ['options' => ['class' => 'form-group'], 'template' => '{input}{hint}{error}'])->dropDownList(
                                            $listData,
                                            ['prompt' => 'Select Category']
                                        )->label('Select Category');
																		
																		?>
  

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'currency')->dropDownList(['USD' => 'USD', 'NGN' => 'NGN'],['prompt'=>'Select Option']); ?>

    <?= $form->field($model, 'is_published')->dropDownList(['0' => 'UNPUBLISH', '1' => 'PUBLISH'],['prompt'=>'Select Option']); ?>
    
    <?= $form->field($model, 'number_credits')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'number_words')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'validity')->textInput() ?>

	</div>
	</div>
		</div>
    <div class="box-footer">
    	<div class="row">
    		<div class=" col-md-6">
    			 <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>	
    		</div>
    	</div>       
    </div>

    <?php ActiveForm::end(); ?>
	</div>
</div>
