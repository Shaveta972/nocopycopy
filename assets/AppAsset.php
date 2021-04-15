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
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot/themes/frontend';
    public $baseUrl = '@web/themes/frontend';
    public $css = [
        'css/jquery.loadingModal.min.css',
         'new/css/bootstrap.min.css',
        'new/css/atlantis.css',
        'css/slick.css',
         'new/style.css',
         'css/style.css',
         'css/main.css',
         'css/media.css',
        'https://use.fontawesome.com/releases/v5.3.1/css/all.css'        


    ];
    public $js = [
      
        
          //  'js/jquery-2.2.4.min.js',
          //  'js/core/jquery.3.2.1.min.js',
            'js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js',
            // 'js/jquery.loadingModal.min.js',
            // 'js/justgage.js',
            // 'js/raphael-2.1.4.min.js',
             'js/core/popper.min.js',
            'js/core/bootstrap.min.js',
            'js/moment.min.js',
            'js/plugin/datepicker/bootstrap-datetimepicker.min.js',
             'js/plugin/jquery-scrollbar/jquery.scrollbar.min.js',
            'js/plugin/chart.js/chart.min.js',
         'js/plugin/jquery.sparkline/jquery.sparkline.min.js',
            'js/plugin/chart-circle/circles.min.js',
            'js/plugin/bootstrap-toggle/bootstrap-toggle.min.js',
            'js/plugin/fullcalendar/fullcalendar.min.js',
             'js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js',
             'js/plugin/jquery.validate/jquery.validate.min.js',
             'js/atlantis.min.js',
                'js/slick.min.js',
        //    'js/app.min.js',
        //    'js/main.js',
        'js/app.min.js',
        'js/main.js',
        'js/jquery.loadingModal.min.js',
        'js/justgage.js',
        'js/raphael-2.1.4.min.js',
           
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    	'yii\bootstrap4\BootstrapPluginAsset' 
    ];
}

