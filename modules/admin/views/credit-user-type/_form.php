<?php

use yii\helpers\Html;
use app\widgets\ActiveForm;
use app\widgets\PageHeader;
/* @var $this yii\web\View */
/* @var $model app\models\CreditUserSettings */
/* @var $form yii\widgets\ActiveForm */

?>
	<?= PageHeader::widget([
    	'title'=>$this->title,
    ]) ?>
<div class="credit-user-settings-form box box-primary">
	<div class="box-header with-border">
    <?php $form = ActiveForm::begin(); ?>
		<div class="box-body">
		<div class="row">
		<div class="col-md-6">
		<?= $form->field($model, 'user_category_id', ['options' => ['class' => 'form-group'], 'template' => '{input}{hint}{error}'])->dropDownList(
                                            $listData,
                                            ['prompt' => 'Select Category']
                                        )->label('Select Category');
																		
																		?>

    <?= $form->field($model, 'credit_value')->textInput() ?>

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
