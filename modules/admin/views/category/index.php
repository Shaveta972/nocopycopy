<?php

use yii\helpers\Html;
use app\widgets\PageHeader;
use app\widgets\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
 	<?= PageHeader::widget([
    	'title'=>$this->title,
    ]) ?>
<div
	class="user-categories-index box box-primary">
	
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="box-header with-border">
        <?= Html::a('Create User Categories', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
	<div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'category_type',
            'category_name',
            'created_at:datetime',
            'updated_at:datetime',
            // [
			// 	'attribute'=>	'created_by',
			// 	'value'=> function ($model){
            //         return isset($model->createUser) ? $model->createUser->fullName : 'NA';
					
			// 	}
			// ],    

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
    <?php Pjax::end(); ?>
</div>
