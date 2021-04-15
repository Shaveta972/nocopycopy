<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UserCategories */

$this->title = 'Create User Categories';
$this->params['breadcrumbs'][] = ['label' => 'User Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-categories-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
