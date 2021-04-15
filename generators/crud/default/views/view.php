<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\widgets\PageHeader;
/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= "<?= " ?>PageHeader::widget([
    	'title'=>$this->title,
    ]) ?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view box box-primary">

	<div class="box-header with-border">
    <p>
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Update') ?>, ['update', <?= $urlParams ?>], ['class' => 'btn btn-primary']) ?>
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Delete') ?>, ['delete', <?= $urlParams ?>], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => <?= $generator->generateString('Are you sure you want to delete this item?') ?>,
                'method' => 'post',
            ],
        ]) ?>
    </p>
	</div>
	<div class="box-body">
    <?= "<?= " ?>DetailView::widget([
        'model' => $model,
        'attributes' => [
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        echo "            '" . $name . "',\n";
    }
} else {
    foreach ($generator->getTableSchema()->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        $variablesToSkip = $generator->getVariablesToSkip();
        
        if($column->name === 'state_id'){
        	echo "            [
		        	'attribute'=>	'$column->name',
		        	'value'=>\$model->getState(\$model->state_id)
        	],    \n";
        	continue;
        }
        
        if($column->name === 'created_by'){
        	echo "            [
					'attribute'=>	'$column->name',
					'value'=>\$model->createdBy ? \$model->createdBy->fullName : 'NA'
        	],    \n";
        }else if(in_array($column->name,['isDeleted','deleted_at'])){
        	continue;
        }else{
        	echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>
        ],
    ]) ?>
</div>
</div>
