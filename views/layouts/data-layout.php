<?php

/* @var $this \yii\web\View */
/* @var $content string */
use app\assets\AppAsset;
use lo\modules\noty\Wrapper;
use yii\helpers\Html;
use yii\helpers\Url;

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
	<link rel="icon" href="https://via.placeholder.com/50" type="image/x-icon"/>
	<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
</head>

<body>
	<?php $this->beginBody(); ?>
	<?php $header_class = 'fixed-top alt-header'; ?>

	<header class="header fixed-top" id="dynamic">
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
											<?php if (!Yii::$app->user->isGuest) { ?>
							<li class="nav-item">
								<div class="dropdown custom-nav-dropdown text-center">
									<button class="btn dropdown-toggle" type="button" data-toggle="dropdown">
										<span class="my_acc">My Account</span>
										<span class="caret"></span></button>
									<ul class="dropdown-menu">
								
										<li class="nav-item"><a class="nav-link" href="<?php echo Url::to(['/site/logout']) ?>">
												<i class="fa fa-sign-out" aria-hidden="true"></i>
												Logout</a>
											</li>
									</ul>
								</div>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</nav>
	</header>
	<?= $content ?>
	<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>