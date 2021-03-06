<?php

use app\widgets\PageHeader;
use yii\widgets\Pjax;
use yii\grid\GridView;
use kartik\export\ExportMenu;
use kartik\mpdf\Pdf;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$url= \Yii::$app->params['WEB_URL'];
$logoimg = \Yii::$app->params['WEB_URL'].'themes/frontend/images/home-logo.png';
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],

    [
        'attribute' => 'Full Name',
        'value' => function ($model) {
            return $model['first_name'] . " " . $model['last_name'];
        }
    ],
    'title',
    'personal_credits',
    'business_credits',
    'assigned_credits',
    [
        'attribute' => 'Plan Credits',
        'value' => function ($model) {
            $credits = ($model['plan_credits'] > 0) ? ($model['plan_credits']) : 0;
            return $credits;
        }
    ],
         [
        //     'attribute' => 'Total Credits',
        //     'value' => function ($model) {
        //         $assigned_credits = ($model['assigned_credits'] > 0) ? ($model['asparams
        'attribute' => 'credits_left',
        'value' => function ($model) {
            $assigned_credits = ($model['assigned_credits'] > 0) ? ($model['assigned_credits']) : 0;
            $credits_used = ($model['credits_used'] > 0) ? ($model['credits_used']) : 0;
            $total_credits = $model['business_credits'] + $model['personal_credits'] + $model['plan_credits'];
            return $total_credits - ($assigned_credits + $credits_used);
        }
    ],
    'created_date:date',
];
$this->title = Yii::t('app', 'Credits Report');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= PageHeader::widget(['title' => $this->title]) ?>
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
                    'filename' => 'PC Builder - Lista de Pe??as - ' . date("d.m.Y H.i.s") . '.pdf', 
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
                   
                     // call mPDF methods on the fly
                     
           'methods' => [
                                'SetHeader' => ['' . '<table width="100%">' . '<tr>' . '<td width="75%"><a target="_blank" href="'.$url.'">
                                <img width="100px" src="'.$logoimg.'"></a></td>' . '<td width="25%" valign="bottom" style="text-align: right"><small>' . date("d/m/Y H:i:s") . 
                                '</small></td>' . '<tr/>' . '</table>' . ''], 
                                'SetFooter' => ['' . '<table width="100%">' . '<tr>' . '<td width="75%"><a target="_blank" href=".$url."><img width="100px" src="'.$logoimg.'"></a></td>' . 
                                '<td width="25%" valign="bottom" style="text-align: right"><small>{PAGENO}</small></td>' . '<tr/>' . '</table>' . '', 'SetDisplayMode'=> ['fullwidth']]
                                ]
                     ]
                
            ],
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
            'columns' =>  $gridColumns
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>

</div>
