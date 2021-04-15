<?php

use yii\helpers\Html;
use app\widgets\PageHeader;
use app\widgets\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PlanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Plans';
$this->params['breadcrumbs'][] = $this->title;
?>
 	<?= PageHeader::widget([
    	'title'=>$this->title,
    ]) ?>
<div
	class="plans-index box box-primary">
	
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="box-header with-border">
        <?= Html::a('Create Plans', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
	<div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
           
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
            'number_credits',
            'validity',
              [
                'label' => 'Publish Status',
                'value' => function($data){
                    return  ($data->is_published == 1) ? "Published" : "UnPublished";
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',  
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
    <?php Pjax::end(); ?>
</div>
