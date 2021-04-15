<?php
// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
include_once( __DIR__.'/../vendor/copyleaks/php-plagiarism-checker/autoload.php');
$config = require __DIR__ . '/../config/web.php';
Yii::setAlias('uploads', dirname(__FILE__) . '/uploads');
// Yii::setAlias("@imagesUrl", "@web/uploads");
(new yii\web\Application($config))->run();
