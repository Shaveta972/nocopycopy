<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */
use app\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Html;

$this->title = 'Login';
$this->params ['breadcrumbs'] [] = $this->title;
?>


<div class="login-box">
	
	<?php if(\Yii::$app->session->hasFlash('adminCreated')){?>
	<div class="alert alert-success alert-dismissible">
		<button type="button" class="close" data-dismiss="alert"
			aria-hidden="true">&times;</button>
		<h4>
			<i class="icon fa fa-check"></i> Admin Created Successfuly!
		</h4>
		<?php echo \Yii::$app->session->getFlash('adminCreated')?>
	</div>	
	<?php }?>
	
	<?php if(\Yii::$app->session->hasFlash('error')){?>
	<div class="alert alert-error alert-dismissible">
		<button type="button" class="close" data-dismiss="alert"
			aria-hidden="true">&times;</button>
		<h4>
			<i class="icon fa fa-check"></i> Admin could not be Created!
		</h4>
		<?php echo \Yii::$app->session->getFlash('error')?>
	</div>	
	<?php }?>
	

	<div class="login-logo">
		<a href="<?php echo Url::home()?>"><b>NoCopy</b></a>
	</div>
	<!-- /.login-logo -->
	<div class="login-box-body">
		<p class="login-box-msg">Sign in to start your session</p>
			
		<?php $form = ActiveForm::begin()?>
			<?php
			
			echo $form->field ( $model, 'email', [ 
					'inputTemplate' => '{input}<span
					class="glyphicon glyphicon-envelope form-control-feedback"></span>' 
			] )->textInput ( [ 
					'placeholder' => 'Email' 
			] )?>
			
				<?php
				
				echo $form->field ( $model, 'password', [ 
						'inputTemplate' => '{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span>' 
				] )->passwordInput ( [ 
						'placeholder' => 'Password' 
				] )?>
		
			<div class="row">
			<div class="col-xs-8">
						<?php echo $form->field($model,'rememberMe',['checkboxTemplate'=>"<div class='checkbox icheck'>\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n{error}\n{hint}\n</div>"])->checkbox()?>
				</div>
			<!-- /.col -->
			<div class="col-xs-4">
				<?php echo Html::submitButton('Sign In',['class'=>'btn btn-primary btn-block btn-flat'])?>
			</div>
			<!-- /.col -->
		</div>
		
		<?php ActiveForm::end()?>
		<!-- <a href="#">I forgot my password</a> -->
	</div>
	<!-- /.login-box-body -->
</div>

<?php

echo $this->registerJs ( "$(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });" )?>
