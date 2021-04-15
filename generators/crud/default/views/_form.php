<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

$variablesToSkipInForm = $generator->getVariablesToSkip();

echo "<?php\n";
?>

use yii\helpers\Html;
use app\widgets\ActiveForm;
use app\widgets\PageHeader;
/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */

?>
	<?= "<?= " ?>PageHeader::widget([
    	'title'=>$this->title,
    ]) ?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form box box-primary">
	<div class="box-header with-border">
    <?= "<?php " ?>$form = ActiveForm::begin(); ?>
		<div class="box-body">
		<div class="row">
		<div class="col-md-offset-3 col-md-6">
<?php foreach ($generator->getColumnNames() as $attribute) {
	if(in_array($attribute, $variablesToSkipInForm)){
		continue ;
	}
    if (in_array($attribute, $safeAttributes)) {
        echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
    }
} ?>
	</div>
	</div>
		</div>
    <div class="box-footer">
    	<div class="row">
    		<div class="col-md-offset-3 col-md-6">
    			 <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Save') ?>, ['class' => 'btn btn-success']) ?>	
    		</div>
    	</div>       
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>
	</div>
</div>
