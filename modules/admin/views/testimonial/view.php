<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Testimonials */

$this->title = $model->testimonials_title;
$this->params['breadcrumbs'][] = ['label' => 'Testimonials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="testimonials-view">

    <h1><?= Html::encode($this->title) ?></h1>

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'testimonials_title',
            'testimonials_url:url',
            'testimonials_name:ntext',
            [
                'attribute' => 'Image',
                'format' => 'raw',
                'value' => function ($model) {   
                   if ($model->testimonials_image!='')
                     return '<img src="/uploads/testimonials/'.$model->testimonials_image.'" class="img-md img-thumbnail">'; else return 'no image';
                },
              ],
            'testimonials_html_text:ntext',
            // 'testimonials_mail',
            // 'testimonials_company',
            // 'testimonials_city',
            'testimonials_country',
            // 'active',
            // 'deleted_at',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'isDeleted',
        ],
    ]) ?>


</div>
