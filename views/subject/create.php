<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Subjects */

$this->title = 'Create Subjects';
$this->params['breadcrumbs'][] = ['label' => 'Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

