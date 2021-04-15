<?php
 
use yii\helpers\Html;
 ?>
<div class="confirm-email">
    <p>Hello <?= Html::encode($user->first_name) ?>,</p>
    <p>Follow the link below  your login credentials </p>
    <?= Html::encode($user->email) ?>
    <?= Html::encode($user->password) ?>
</div>