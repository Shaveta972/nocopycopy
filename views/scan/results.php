<?php
use app\models\User;
use yii\helpers\Url;
use yii\widgets\ListView;
// use kartik\grid\ListView;
use kartik\export\ExportMenu;
use kartik\mpdf\Pdf;

$this->title = \Yii::t('app', 'Results');
$url= \Yii::$app->params['WEB_URL'];
$logoimg = \Yii::$app->params['WEB_URL'].'themes/frontend/images/home-logo.png';
$gridColumns = [
    'process_id',
    'url',
    'title',
    'introduction',
    'percents',
    'number_copied_words',

];
$gridExportColumns = [
    'url',
    'title',
    'percents',
    'number_copied_words',
];
?>

<div class="results" style="padding-top:90px; ">
<iframe id="frameId"  style="width:100%; height:800px" frameBorder="0" src="<?= $embed_report; ?>"></iframe>
 </div>