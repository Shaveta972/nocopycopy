<?php

use app\widgets\PageHeader;
use yii\widgets\Pjax;
use yii\grid\GridView;
use kartik\bs4dropdown\Dropdown;
use kartik\export\ExportMenu;
use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this);
use kartik\mpdf\Pdf;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$url= \Yii::$app->params['WEB_URL'];
$logoimg = \Yii::$app->params['WEB_URL'].'themes/frontend/images/home-logo.png';
$this->title = Yii::t('app', 'Sales Report');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= PageHeader::widget(['title' => $this->title]) ?>
<?php 
$gridColumns= [
    [
        'class' => 'yii\grid\SerialColumn'
    ],
    [
        'attribute' => 'full_name',
        'label' => 'Full Name',
        'value' => function ($model) {
            return $model->first_name . " " . $model->last_name;
        },
    ],
    [
        'attribute' => 'email',
        'label' => 'Email Address',
    ],
    'title',
    'amount_paid',
    'created_at:date',
    'expiration_date:date',
];
?>
<div class="user-index box box-primary">


    <div class="box-body">
    <div class="box-tools pull-right mb-4">
    <?php
    echo ExportMenu::widget([
        'dataProvider' => $exportDataProvider,
        'exportConfig' => [
            ExportMenu::FORMAT_TEXT => false,
            ExportMenu::FORMAT_HTML => false,
            ExportMenu::FORMAT_PDF => [
                'label' => Yii::t('app', 'PDF'),
                // 'icon' => $isFa ? 'file-pdf-o' : 'floppy-disk',
                'iconOptions' => ['class' => 'text-danger'],
                // 'options' => ['title' => Yii::t('app', 'Portable Document Format')],
                'alertMsg' => Yii::t('app', 'The PDF export file will be generated for download.'),
                'mime' => 'application/pdf',
                'extension' => 'pdf',
                'writer' => 'NoCopyCopy', // custom Krajee PDF writer using MPdf library
                'useInlineCss' => true,
                'pdfConfig' =>[
                    'mode' => Pdf::MODE_CORE, 
                    // A4 paper format
                    'format' => Pdf::FORMAT_A4, 
                    'filename' => 'PC Builder - Lista de Peças - ' . date("d.m.Y H.i.s") . '.pdf', 
                    // portrait orientation
                    'orientation' => Pdf::ORIENT_PORTRAIT   , 
                    // stream to browser inline
                    'destination' => Pdf::DEST_BROWSER, 
                    'marginTop' => 20,
                    'marginBottom' => 20,
                    'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
                     'options' => [
                        'title' => 'NoCopyCopy',
                        'subject' => Yii::t('app', 'PDF export generated by NoCopyCopy'),

                     ],
                    'SetHeader' => ['' . '<table width="100%">' . '<tr>' . '<td width="75%"><a target="_blank" href="'.$url.'">
                    <img width="100px" src="'.$logoimg.'"></a></td>' . '<td width="25%" valign="bottom" style="text-align: right"><small>' . date("d/m/Y H:i:s") . 
                    '</small></td>' . '<tr/>' . '</table>' . ''], 
                    'SetFooter' => ['' . '<table width="100%">' . '<tr>' . '<td width="75%"><a target="_blank" href=".$url."><img width="100px" src="'.$logoimg.'"></a></td>' . 
                    '<td width="25%" valign="bottom" style="text-align: right"><small>{PAGENO}</small></td>' . '<tr/>' . '</table>' . '', 'SetDisplayMode'=> ['fullwidth']]
                    ]
                ] 
            ],
        'dropdownOptions' => [
            'label' => 'Export All',
            'class' => 'btn btn-primary'
        ],
        'columns' => $gridColumns
    ]);
    ?>

    </div>
        <?php Pjax::begin(); ?>
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>

</div>