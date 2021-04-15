<?php

use yii\helpers\Html;
use app\widgets\PageHeader;
use app\widgets\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CreditUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Credit User Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
 	<?= PageHeader::widget([
    	'title'=>$this->title,
    ]) ?>
<div
	class="credit-user-settings-index box box-primary">
	
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="box-header with-border">
        <?= Html::a('Create Credit User Settings', ['create'], ['class' => 'btn btn-success']) ?>
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
            'credit_value',
            'created_at:datetime',
            'updated_at:datetime',   

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
    <?php Pjax::end(); ?>
</div>
