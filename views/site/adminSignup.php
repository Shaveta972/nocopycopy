<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */
use app\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Html;

$this->title = 'Sigup as admin';
$this->params ['breadcrumbs'] [] = $this->title;
?>
<div class="login-box">
	<div class="login-logo">
		<a href="<?php echo Url::home()?>"><b>Table for two</b></a>
	</div>
	<!-- /.login-logo -->
	<div class="login-box-body">
		<h4 class="text-center">Signup as admin</h4>
		
			
		<?php $form = ActiveForm::begin()?>
		
		<?php echo $form->errorSummary($model)?>
		
		<?=$form->field ( $model, 'first_name' )->textInput ( [ 'placeholder' => 'First Name' ] )?>
		
		<?=$form->field ( $model, 'last_name' )->textInput ( [ 'placeholder' => 'Last Name' ] )?>
	
		<?=$form->field ( $model, 'username' )->textInput ( [ 'placeholder' => 'Username' ] )?>
			
		<?=$form->field ( $model, 'email' )->textInput ( [ 'placeholder' => 'Email' ] )?>
			
		<?=$form->field ( $model, 'password' )->passwordInput ( [ 'placeholder' => 'Password' ] )?>
		
		<?=$form->field ( $model, 'confirmPassword' )->passwordInput ( [ 'placeholder' => 'Confirm Password' ] )?>
		
			<div class="row">
			<div class="col-xs-4">
				<?php echo Html::submitButton('Sign Up',['class'=>'btn btn-primary btn-block btn-flat'])?>
			</div>
			<div class="col-xs-8"></div>
			<!-- /.col -->
		</div>
		
		<?php ActiveForm::end()?>
	</div>
	<!-- /.login-box-body -->
</div>

