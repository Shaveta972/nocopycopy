<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = \Yii::t('app', 'Update Profile');
echo \yii2mod\alert\Alert::widget();
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


