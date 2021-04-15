<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\widgets\PageHeader;
/* @var $this yii\web\View */
/* @var $model app\models\Plans */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= PageHeader::widget([
    	'title'=>$this->title,
    ]) ?>

<div class="plans-view box box-primary">

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
            'id',
            [
                'label' => 'Category Name',
                'value' => function($data){
                    $model=  new  app\models\UserCategories();
                    $catData= $model->findCategoryNameByID($data->user_category_id);
                    return $catData->category_name;
                }
            ],
            
            'title',
            'price',
            'currency',
              [
                'label' => 'Publish Status',
                'value' => function($data){
                    return  ($data->is_published == 1) ? "Published" : "UnPublished";
                }
            ],
            'number_credits',
            'validity',
            'created_at:datetime',
            'updated_at:datetime',
         
        ],
    ]) ?>
</div>
</div>
