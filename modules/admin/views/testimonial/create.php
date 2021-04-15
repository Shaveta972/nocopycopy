<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Testimonials */

$this->title = 'Create Testimonials';
$this->params['breadcrumbs'][] = ['label' => 'Testimonials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testimonials-create box box-primary">
<div class="box-header with-border"></div>
	<div class="box-body">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
    </div> 
