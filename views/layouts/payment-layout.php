<?php

/* @var $this \yii\web\View */
/* @var $content string */
use app\widgets\NavbarMenu;
use yii\base\Widget;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;

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
  <link href="<?php echo Url::to('@web/themes/frontend/css/bootstrap.min.css',true)?>" rel="stylesheet">
  <link href="<?php echo Url::to('@web/themes/frontend/css/bootstrap-slider.min.css',true)?>" rel="stylesheet">
  <link href="<?php echo Url::to('@web/themes/frontend/css/main.css',true)?>" rel="stylesheet">
  <link href="<?php echo Url::to('@web/themes/frontend/css/style.css',true)?>" rel="stylesheet">
  <link href="<?php echo Url::to('@web/themes/frontend/css/media.css',true)?>" rel="stylesheet">
</head>
<body>
<?php $this->beginBody() ?>
                                                                                               

<?= $content ?>

<script src="<?php echo Url::to('@web/themes/frontend/js/jquery-3.3.1.min.js',true)?>"></script>
<script src="<?php echo Url::to('@web/themes/frontend/js/bootstrap.min.js',true)?>"></script>
<script src="<?php echo Url::to('@web/themes/frontend/js/slick.min.js',true)?>"></script>
<script src="<?php echo Url::to('@web/themes/frontend/js/main.js',true)?>"></script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
