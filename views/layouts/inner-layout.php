<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use lo\modules\noty\Wrapper;
use yii\helpers\Html;
use yii\helpers\Url;
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
	<link rel="icon" href="https://via.placeholder.com/50" type="image/x-icon"/>
	<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
</head>
<body>
<div class="wrapper">
	<?php $this->beginBody(); ?>
	<?php $header_class = 'fixed-top alt-header'; ?>


		<header class="header main-header fixed-top" id="dynamic">
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
							<?php } else {
								?>
								<a class="nav-link btn-round" href="<?php echo Url::to(['/site/register']) ?>">
									<?php //echo Html::img('@web/themes/frontend/images/user-icon.png', ['alt' => "user"]) ?>
								</a>
							<?php
							}
							?>
						</li>
						<?php  if (!Yii::$app->user->isGuest) { ?>
						
						<li class="nav-item dropdown hidden-caret ">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">

							<div class="avatar-sm">
                            <?php if (empty(Yii::$app->user->identity->profile_picture)) {
                                echo Html::img('@web/themes/frontend/images/default_avatar.png', ['class' => 'avatar-img rounded-circle']);
                            } else { ?>
                                <img src='<?php echo Yii::getAlias('@imagesUrl') . '/' .  Yii::$app->user->identity->profile_picture; ?>' class="avatar-img rounded-circle">
                            <?php } ?>
                        	</div>
								
								<div class="avt_txt">
								
									<span><?php echo Yii::$app->user->identity->first_name. " ".Yii::$app->user->identity->last_name; ?></span>
									<?php echo Html::img('@web/themes/frontend/new_images/arrow_down.svg', ['alt' => "user"]) ?>
									
								</div>
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<div class="dropdown-user-scroll scrollbar-outer">
									<li>
										<a class="dropdown-item" href="<?php echo Url::to(['user/update', 'id' => Yii::$app->user->id]); ?>">Manage Profile</a>
									</li>
									<li>
										<a class="dropdown-item" href="<?php echo Url::to(['user/settings', 'id' => Yii::$app->user->id]); ?>">Account Settings</a>
									</li>
									<li>
										<a class="dropdown-item" href="<?php echo Url::to(['/site/logout']) ?>">
										<?php echo Html::img('@web/themes/frontend/new_images/logout.svg', ['alt' => "logout"]) ?>
										 Logout</a>
									</li>
								</div>
							</ul>
						</li>
						
						<?php } ?>
		
					</ul>
				</div>
			</div>
		</nav>
	</header>

<!-- Sidebar -->
<?php

if (!Yii::$app->user->isGuest) { ?>
<div class="sidebar sidebar-style-2">			
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<ul class="nav nav-primary">
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
						</li>
						<li class="nav-item">
							<a href="<?php echo Url::to(['user/dashboard']); ?>">
                            <?php echo Html::img('@web/themes/frontend/new_images/home.svg', ['alt' => "home", 'class' => '']); ?>
								<p>Dashboard</p>
							</a>
						</li>
							
						<?php
									
					if (isset(Yii::$app->user->identity->is_subadmin) && Yii::$app->user->identity->is_subadmin == User::TEACHER_SUBADMIN) { ?>
							<li class="nav-item">
								<a href="<?php echo Url::to(['/subject']); ?>">
								<?php echo Html::img('@web/themes/frontend/new_images/subjects-icn.svg', ['alt' => "subjects", 'class' => '']); ?> 
								<p>Manage Subjects</p>
							</a>
							</li>
						<?php } ?>
						<?php if (Yii::$app->user->identity->parent_id == 0 && !empty(Yii::$app->user->identity->referal_code)) { ?>
							<li class="nav-item">
								<a href="<?php echo Url::to(['user/referals']); ?>">
								<?php echo Html::img('@web/themes/frontend/new_images/jobs.svg', ['alt' => "jobs", 'class' => '']); ?>
								<p>Manage Referrals</p>
							</a>
							</li>
						<?php } ?>
					
						<!-- <li class="nav-item">
							<a data-toggle="collapse" href="#maps">
                            <?php //echo Html::img('@web/themes/frontend/new_images/calander.svg', ['alt' => "calander"]) ?>
							
								<p>My Scans</p>
							</a>
						</li> -->
						<li class="nav-item">
											
							<a  href="<?php echo Url::to(['user/transactions', 'id' => Yii::$app->user->id]); ?>">
                            <?php echo Html::img('@web/themes/frontend/new_images/transaction.svg', ['alt' => "transaction"]) ?>
							
								<p>My Transactions</p>
							</a>
						</li>

						<?php if (isset(Yii::$app->user->identity->is_subadmin) && Yii::$app->user->identity->is_subadmin == User::STUDENT_SUBADMIN) { ?>
                            <li class="nav-item">
							<a  href="<?php echo Url::to(['user/uploads', 'id' => Yii::$app->user->id]); ?>">
								<p>View Assignments</p>
                                    <?php echo Html::img('@web/themes/frontend/new_images/calander.svg', ['alt' => "calander"]) ?></a>
                            </li>

						<?php } ?>
						
						<?php 
						if (
							
							Yii::$app->user->identity->user_category_id == 2) { ?>
                            <li class="nav-item">
								<a href="<?php echo Url::to(['user/lecturers', 'id' => Yii::$app->user->id]); ?>">
								<p>Lecturers</p>
								<?php echo Html::img('@web/themes/frontend/new_images/calander.svg', ['alt' => "calander"]) ?></a>
                            </li>
                            <li class="nav-item">
							<a href="<?php echo Url::to(['user/students', 'id' => Yii::$app->user->id]); ?>"><p>Students</p>
								<?php echo Html::img('@web/themes/frontend/new_images/calander.svg', ['alt' => "calander"]) ?></a>
                            </li>
						<?php } ?>
						  
				<?php if (isset(Yii::$app->user->identity->is_subadmin) && 
							!is_null(Yii::$app->user->identity->is_subadmin) && 
							Yii::$app->user->identity->is_subadmin == User::TEACHER_SUBADMIN) { ?>
                    <li class="nav-item">
					<a href="<?php echo Url::to(['user/assignments', 'id' => Yii::$app->user->id]); ?>"><p>	View Assignments</p>
                            <?php echo Html::img('@web/themes/frontend/new_images/calander.svg', ['alt' => "calander"]) ?></a>
                    </li>

                <?php } ?>
 

                        <?php if (Yii::$app->user->identity->user_category_id == 3) { ?>
                            <li class="nav-item">
							<a href="<?php echo Url::to(['user/members', 'id' => Yii::$app->user->id]); ?>"><p>	View Members</p>
								<?php echo Html::img('@web/themes/frontend/new_images/calander.svg', ['alt' => "calander"]) ?>
							</a>
                            </li>

                        <?php } ?>
                       
						<li class="nav-item">
						<a  href="<?php echo Url::to(['user/settings', 'id' => Yii::$app->user->id]); ?>">												
                            <?php echo Html::img('@web/themes/frontend/new_images/calander.svg', ['alt' => "calander"]) ?>
							
								<p>Account Settings</p>
							</a>
						</li>
						<li class="nav-item">
						<a  href="<?php echo Url::to(['user/profile', 'id' => Yii::$app->user->id]); ?>">												
                            <?php echo Html::img('@web/themes/frontend/new_images/calander.svg', ['alt' => "calander"]) ?>
							
								<p>View Profile</p>
							</a>
						</li>
						<li class="nav-item">
						<a  href="<?php echo Url::to(['/site/logout']) ?>">
                            <?php echo Html::img('@web/themes/frontend/new_images/logout.svg', ['alt' => "transaction"]) ?>
								<p>Logout</p>
							</a>
						</li>
					</ul>

				</div>
			</div>
		</div>
<?php } ?>
		<!-- End Sidebar -->
	<?php
	echo Wrapper::widget([
		'layerClass' => 'lo\modules\noty\layers\Noty',
		'layerOptions' => [
			// for every layer (by default)
			'layerId' => 'noty-layer',
			'customTitleDelimiter' => '|',
			'overrideSystemConfirm' => true,
			'showTitle' => true,
			// for custom layer
			'registerAnimateCss' => true,
			'registerButtonsCss' => false
		],
		// clientOptions
		'options' => [
			'dismissQueue' => true,
			'layout' => 'topRight',
			'timeout' => 3000,
			'theme' => 'relax',
			// and more for this library...
		],
	]);
	?>
	<div class="main-panel">
	<?= $content ?>
	<footer class="footer">
				<div class="container-fluid">
					
					<div class="copyright ">
						©2020 NoCopyCopy Private Limited | All rights reserved
					</div>	
					<nav class="pull-left ml-auto">
						<ul class="nav">
							<li class="nav-item">  
								<a class="nav-link" href="<?php echo Url::to(['site/terms']); ?>">	
								Terms of Use
								</a>
							</li>
							<!-- <li class="nav-item">
								<a class="nav-link" href="#">
								Privacy Policy
								
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">
									FAQ’s
								</a>
							</li> -->
							<li class="nav-item">
							<a class="nav-link" href="<?php echo Url::to(['site/contact']); ?>">	
									Contact Support
								</a>
							</li>
						</ul>
					</nav>			
				</div>
			</footer>
</div>	
	<?php $this->endBody() ?>
	</div>
</body>

</html>
<?php $this->endPage() ?>