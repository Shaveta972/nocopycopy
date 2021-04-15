<?php

/* @var $this \yii\web\View */
/* @var $content string */
use app\assets\AppAsset;
use lo\modules\noty\Wrapper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;
use app\models\User;
AppAsset::register($this);
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
</head>

<body>
<div class="wrapper">
	<?php $this->beginBody(); ?>
	<div class="spinner-border loader" role="status" style="display:none">
		<span class="sr-only">Loading...</span>
	</div>

	<?php
	//echo Yii::$app->request->url;
	$headerClass = \Yii::$app->homeUrl === Yii::$app->request->url ? "header fixed-top alt-header" : "header";
	?>

	<header class="<?php echo $headerClass ?>" id="dynamic">
		<nav class="navbar navbar-expand-lg navbar-light">
			<div class="container">
				<a class="navbar-brand" href="<?php echo Url::to(['/']) ?>">
					<?php echo Html::img('@web/themes/frontend/images/home-logo.png', ['alt' => "home"]) ?>
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item active">
							<a class="nav-link" href="<?php echo Url::to(['/']) ?>">Home</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo Url::to(['/site/features']) ?>">Features</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo Url::to(['/site/plans']) ?>">Pricing</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo Url::to(['/site/contact']) ?>">Get in touch</a>
						</li>
						<?php if (Yii::$app->user->isGuest) { ?>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo Url::to(['/site/login']) ?>">Login</a>

							</li>
						<?php }
					?>
						<li class="nav-item">
							<?php
							if (!Yii::$app->user->isGuest) { ?>
								<a class="nav-link btn-round" href="#">
									<?php echo Html::img('@web/themes/frontend/images/user-icon.png', ['alt' => "user"]) ?>
								</a>
							<?php } else {
							?>
								<a class="nav-link btn-round" href="<?php echo Url::to(['/site/register']) ?>">
									<?php echo Html::img('@web/themes/frontend/images/user-icon.png', ['alt' => "user"]) ?>
								</a>
							<?php
						}
						?>
						</li>
						<?php if (!Yii::$app->user->isGuest) { ?>
							<li class="nav-item">
								<div class="dropdown custom-nav-dropdown text-center">
									<button class="btn dropdown-toggle" type="button" data-toggle="dropdown">
										<span class="my_acc">My Account</span>
										<span class="caret"></span></button>
									<ul class="dropdown-menu">
										<li class="nav-item">
										<a class="nav-link border-bottom text-left" href="<?php echo Url::to(['user/dashboard']); ?>">
												<i class="fa fa-dashboard" aria-hidden="true"></i>
												View Dashboard</a>
												
											
											</li>

											<li class="nav-item">
												<a class="nav-link border-bottom text-left" href="<?php echo Url::to(['user/profile', 'id' => Yii::$app->user->id]); ?>">
												<i class="fa fa-user" aria-hidden="true"></i>
												View Profile</a>
												
											</li>
											<?php
									
									if (isset(Yii::$app->user->identity->is_subadmin) && Yii::$app->user->identity->is_subadmin == User::TEACHER_SUBADMIN) { ?>
										<li class="nav-item">
											<a class="nav-link border-bottom text-left" href="<?php echo Url::to(['/subject']); ?>">
												<i class="fa fa-list" aria-hidden="true"></i>  Subjects</a>
										</li>
									<?php } ?>
											<?php if( Yii::$app->user->identity->parent_id == 0 ){ ?>
											<li class="nav-item">
											<a class="nav-link border-bottom text-left" href="<?php echo Url::to(['user/referals']); ?>">
												<i class="fa fa-user" aria-hidden="true"></i> Referrals</a>
											</li>
											<?php } ?>
									
										<li class="nav-item"><a class="nav-link text-left" href="<?php echo Url::to(['/site/logout']) ?>">
												<i class="fa fa-sign-out" aria-hidden="true"></i>
												Logout</a></li>
									</ul>
								</div>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</nav>
	</header>

	<?php
	// echo Wrapper::widget([
	// 	'layerClass' => 'lo\modules\noty\layers\Noty',
	// 	'layerOptions' => [
	// 		// for every layer (by default)
	// 		'layerId' => 'noty-layer',
	// 		'customTitleDelimiter' => '|',
	// 		'overrideSystemConfirm' => true,
	// 		'showTitle' => true,
	// 		// for custom layer
	// 		'registerAnimateCss' => true,
	// 		'registerButtonsCss' => false
	// 	],
	// 	// clientOptions
	// 	'options' => [
	// 		'dismissQueue' => true,
	// 		'layout' => 'topRight',
	// 		'timeout' => 3000,
	// 		'theme' => 'relax',
	// 		// and more for this library...
	// 	],
	// ]);
	?>
	<?= $content ?>
	<?php $this->endBody() ?>
	</div>
</body>

</html>
<?php $this->endPage() ?>