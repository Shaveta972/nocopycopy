<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\widgets\PageHeader;
/* @var $this yii\web\View */
/* @var $model app\models\CreditUserSettings */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Credit User Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'View Credits';
?>

<?= PageHeader::widget([
    	'title'=> 'View Credits'
    ]) ?>

<div class="credit-user-settings-view box box-primary">

	<div class="box-header with-border">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
	</div>
	<div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Category Name',
                'value' => function($data){
                    $model=  new  app\models\UserCategories();
                    $catData= $model->findCategoryNameByID($data->user_category_id);
                    return $catData->category_name;
                }
            ],
            'credit_value',
            'created_at:datetime',
            'updated_at:datetime',
            // [
			// 		'attribute'=>	'created_by',
			// 		'value'=>$model->createdBy ? $model->createdBy->fullName : 'NA'
        	// ],    
        ],
    ]) ?>
</div>
</div>
