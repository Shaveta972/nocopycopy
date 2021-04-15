<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LoginAsset extends AssetBundle {
	public $basePath = '@webroot/themes/backend';
	public $baseUrl = '@web/themes/backend';
	public $css = [
			'bower_components/font-awesome/css/font-awesome.min.css',
			'bower_components/Ionicons/css/ionicons.min.css',
			'dist/css/AdminLTE.min.css',
			'plugins/iCheck/square/blue.css'
	];
	public $js = [
			'plugins/iCheck/icheck.min.js'
	];
	public $depends = [
			'yii\web\YiiAsset',
			'yii\bootstrap\BootstrapAsset',
			'yii\bootstrap\BootstrapPluginAsset'
	];
}
