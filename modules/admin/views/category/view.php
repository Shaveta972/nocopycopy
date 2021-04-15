<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\widgets\PageHeader;
/* @var $this yii\web\View */
/* @var $model app\models\UserCategories */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'View Category'
?>

<?= PageHeader::widget([
    	'title'=> 'View Category'
    ]) ?>

<div class="user-categories-view box box-primary">

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
            'category_type',
            'category_name',
            'created_at:datetime',
            'updated_at:datetime'   
        ],
    ]) ?>
</div>
</div>
