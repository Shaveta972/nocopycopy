<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\widgets\PageHeader;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Testimonials';
$this->params['breadcrumbs'][] = $this->title;
?>
<?=PageHeader::widget ( [ 'title' => $this->title ] )?>
<div class="testimonials-index box box-primary">
<div class="box-header with-border"></div>
	<div class="box-body">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a('Create Testimonial', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'testimonials_title',
            'testimonials_url:url',
            'testimonials_name:ntext',
              [
        'attribute' => 'image',
        'format' => 'html',    
        'value' => function ($data) {
            return Html::img(Yii::getAlias('@web').'/uploads/testimonials/'. $data->testimonials_image,
                ['width' => '70px']);
        },
    ],
           
              [
                'attribute' => 'Status',
                'format' => 'raw',
                'value' => function ($model) {   
                    return  ($model->active ==1) ? '<div class="col-form-label-sm"><label class="label label-success">Active</label></div>' : '<label class="label label-danger">InActive</label>';
                },
              ],
              
            //'testimonials_html_text:ntext',
            //'testimonials_mail',
            //'testimonials_company',
            //'testimonials_city',
            //'testimonials_country',
            //'active',
            //'deleted_at',
            //'created_at',
            //'updated_at',
            //'created_by',
            //'isDeleted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>

