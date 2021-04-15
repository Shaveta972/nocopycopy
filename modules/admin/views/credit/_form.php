<?php

use yii\helpers\Html;
use app\widgets\ActiveForm;
use app\widgets\PageHeader;
/* @var $this yii\web\View */
/* @var $model app\models\CreditScanSettings */
/* @var $form yii\widgets\ActiveForm */

?>
<?= PageHeader::widget([ 'title' => $this->title ]) ?>

<div class="credit-scan-settings-form box box-primary">
	<div class="box-header with-border">
		<?php $form = ActiveForm::begin(); ?>
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'doc_type')->dropDownList(['text' => 'Text', 'url' => 'Url', 'file' => 'File',], ['prompt' => '']) ?>
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