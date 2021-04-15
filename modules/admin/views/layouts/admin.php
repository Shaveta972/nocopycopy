<?php

/* @var $this \yii\web\View */
/* @var $content string */
use app\assets\BackendAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\SidebarMenu;
use yii\base\Widget;

BackendAsset::register ( $this );
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<?php $this->beginBody() ?>
<div class="wrapper">
		<header class="main-header">
			<!-- Logo -->
			<a href="<?php echo Url::to(['dashboard/index'])?>" class="logo"> <!-- mini logo for sidebar mini 50x50 pixels -->
				<span class="logo-mini"><b>NC</b></span> <!-- logo for regular state and mobile devices -->
				<span class="logo-lg"><b>NoCopy Copy</b></span>
			</a>
			<!-- Header Navbar: style can be found in header.less -->
			<nav class="navbar navbar-static-top">
				<!-- Sidebar toggle button-->
				<a href="#" class="sidebar-toggle" data-toggle="push-menu"
					role="button"> <span class="sr-only">Toggle navigation</span>
				</a>

				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu"><a href="#"
							class="dropdown-toggle" data-toggle="dropdown"> <img
								src="<?php echo \Yii::$app->user->identity->profileImage ?>"
								class="user-image" alt="User Image"> <span class="hidden-xs"><?php echo \Yii::$app->user->identity->fullName?></span>
						</a>
							<ul class="dropdown-menu">
								<!-- User image -->
								<li class="user-header"><img
									src="<?php echo \Yii::$app->user->identity->profileImage?>"
									class="img-circle" alt="User Image">

									<p>
										<?php echo \Yii::$app->user->identity->fullName?> <small>Member since <?php echo \Yii::$app->formatter->asDate(\Yii::$app->user->identity->created_at)?></small>
									</p></li>

								<li class="user-footer">
									<!-- <div class="pull-left">
										<a href="#" class="btn btn-default btn-flat">Profile</a>
									</div> -->
									<div class="pull-left">
										<a href="<?php echo Url::to(['/admin/user/logout'])?>"
											class="btn btn-default btn-flat">Sign out</a>
									</div>
								</li>
							</ul></li>
						<!-- Control Sidebar Toggle Button -->
						<!-- <li><a href="#" data-toggle="control-sidebar"><i
								class="fa fa-gears"></i></a></li> -->
					</ul>
				</div>
			</nav>
		</header>
		<!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar">
			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">
				<!-- Sidebar user panel -->
				<div class="user-panel">
					<div class="pull-left image">
						<img src="<?php echo \Yii::$app->user->identity->profileImage?>"
							class="img-circle" alt="User Image">
					</div>
					<div class="pull-left info">
						<p><?php echo \Yii::$app->user->identity->fullName?></p>
						<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
					</div>
				</div>
				<!-- /.search form -->
				<!-- sidebar menu: : style can be found in sidebar.less -->
				<?php echo SidebarMenu::widget()?>
			</section>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<?php
			
			if (isset ( $this->blocks ['pageHeader'] )) {
				echo $this->blocks ['pageHeader'];
			}
			?>
			<section class="content">
			<?= $content ?>
			</section>
		</div>
		<!-- /.content-wrapper -->
		<footer class="main-footer">
			<strong>Copyright &copy; 2019-2020 <a
				href="<?php echo Url::to(['/admin/dashboard'])?>">NoCopy Copy</a>.
			</strong> All rights reserved.
		</footer>

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Create the tabs -->
			<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
			</ul>
			<!-- Tab panes -->
			<div class="tab-content">
				<!-- Home tab content -->
				<div class="tab-pane" id="control-sidebar-home-tab"></div>
				<!-- /.tab-pane -->
				<!-- Stats tab content -->
				<!-- /.tab-pane -->
				<!-- /.tab-pane -->
			</div>
		</aside>
		<!-- /.control-sidebar -->
		<!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
		<div class="control-sidebar-bg"></div>
	</div>
	
	<?php 
		$this->registerJs("
				setTimeout(function(){
					$(window).resize();		
				},0);
		");
	?>
	
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
