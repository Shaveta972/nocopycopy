<?php
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams ();
$nameAttribute = $generator->getNameAttribute ();

echo "<?php\n";
?>

use yii\helpers\Html;
use app\widgets\PageHeader;
use <?= $generator->indexWidgetType === 'grid' ? "app\\widgets\\GridView" : "app\\widgets\\ListView" ?>;
<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
 	<?= "<?= " ?>PageHeader::widget([
    	'title'=>$this->title,
    ]) ?>
<div
	class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index box box-primary">
	
<?= $generator->enablePjax ? "    <?php Pjax::begin(); ?>\n" : '' ?>
<?php if(!empty($generator->searchModelClass)): ?>
<?= "    <?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>

    <div class="box-header with-border">
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, ['create'], ['class' => 'btn btn-success']) ?>
    </div>
	<div class="box-body">
<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?= " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
            ['class' => 'yii\grid\SerialColumn'],

<?php
	$count = 0;
	if (($tableSchema = $generator->getTableSchema ()) === false) {
		foreach ( $generator->getColumnNames () as $name ) {
			if (++ $count < 6) {
				echo "            '" . $name . "',\n";
			} else {
				echo "            //'" . $name . "',\n";
			}
		}
	} else {
		foreach ( $tableSchema->columns as $column ) {
			$format = $generator->generateColumnFormat ( $column );
			if (in_array ( $column->name, ['isDeleted','deleted_at'])) {
				continue;
			}
			
			if ($column->name === 'description' || $column->name === 'content') {
				continue;
			}
			
			if ($column->name === 'state_id') {
				echo "            [
				'attribute'=>	'$column->name',
				'filter'=>\$searchModel->getStateOptions(),
				'value'=> function (\$model){
						return \$model->getState(\$model->state_id);
				}
			],    \n";
				continue;
			}
			
			if ($column->name === 'created_by') {
				echo "            [
				'attribute'=>	'$column->name',
				'value'=> function (\$model){
					return isset(\$model->createdBy) ? \$model->createdBy->fullName : 'NA';
				}
			],    \n";
			} else if (++ $count < 6) {
				echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
			} else {
				echo "            //'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
			}
		}
	}
	?>

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php else: ?>
    <?= "<?= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
    ]) ?>
<?php endif; ?>
</div>
<?= $generator->enablePjax ? "    <?php Pjax::end(); ?>\n" : '' ?>
</div>
