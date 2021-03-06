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

<div class="results" style="padding-top:90px;">
    <div class="container">
        <div class="row my-3">
            <div class="col-md-7">
                <ol class="breadcrumb margin-from-menu">
                    <li><a href="<?php echo Url::home() ?>" alt="home">Home</a></li>
                    <li><a href="<?php echo Url::to(['/user/dashboard/' . $user_request->user_id]); ?> ">Dashboard</a></li>
                    <li class="active"><?php echo $user_request->process_id; ?></li>
                </ol>
            </div>

            <div class="col-md-5 text-right">
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
                                'format' => Pdf::FORMAT_LEGAL, 
                                'filename' => 'PC Builder - Lista de Pe??as - ' . date("d.m.Y H.i.s") . '.pdf', 
                                // portrait orientation
                                'orientation' => Pdf::ORIENT_LANDSCAPE, 
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
                                'SetHeader' => ['' . '<table width="100%">' . '<tr>' . '<td width="75%"><a target="_blank" href="https://nocopycopy.ng">
                                <img width="100px" src="'.$logoimg.'"></a></td>' . '<td width="25%" valign="bottom" style="text-align: right"><small>' . date("d/m/Y H:i:s") . 
                                '</small></td>' . '<tr/>' . '</table>' . ''], 
                                'SetFooter' => ['' . '<table width="100%">' . '<tr>' . '<td width="75%"><a target="_blank" href=".$url."><img width="100px" src="'.$logoimg.'"></a></td>' . 
                                '<td width="25%" valign="bottom" style="text-align: right"><small>' .$url. 
                                '</small></td>' . '<tr/>' . '</table>' . '', 'SetDisplayMode'=> ['fullwidth']]
                                ]
                              
                                // 'methods' => [ 
                                //     'SetHeader'=>['NoCopyCopy'], 
                                //     'SetFooter'=>['{PAGENO}'],
                                // ],
                                // 'contentBefore'=>'aaaaaaaaaaaaaaaa',
                                // 'contentAfter'=>'sssssssssssssssssssssssssss'
                            ]
                            
                        ],
                    ],
                    'dropdownOptions' => [
                        'label' => 'Export All',
                        'class' => 'btn btn-blue'
                    ],
                    'columns' => $gridExportColumns
                ]);
                ?>
                <a href="<?php echo Url::to(['/site/front/']); ?>" class="btn btn-blue">
                    <i class="fa fa-plus"></i>
                    New Scan
                </a>
            </div>
        </div>
        <section class="my-2">
            <input type="hidden" value="0" id="page_load">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-cascade wider reverse">
                        <div class="card-body card-body-cascade row">
                            <div class="process-content-left col-md-1 d-flex justify-content-center">
                                <?php if($user_request['process_type']=='text'){ ?>
                                <i class="fa fa-text-height fa-4x mt-2 text-center" aria-hidden="true"></i> 
                                <?php } 
                                else if($user_request['process_type']=='file'){ ?>
                                  <i class="fa fa-file fa-4x mt-2 text-center" aria-hidden="true"></i> 
                               <?php }
                                else{ ?>
                                    <i class="fa fa-link fa-5x mt-2 text-center" aria-hidden="true"></i> 
                              <?php  }
                                ?>
                            </div>
                            <div class="process-content col-md-9">
                                <h3 class="mb-3"><a>
                                        <?php echo User::limit_text($user_request['process_value'], 14); ?>

                                    </a></h3>
                                <div class="process-info d-flex justify-content-between">
                                    <a class="btn btn-red">
                                        <i class="fa fa-bookmark pr-2"></i>
                                        <span class="clearfix d-none d-md-inline-block">Results <?php echo $count_records; ?></span>
                                    </a>

                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="words-count align-center">
                                    <ul class="WordsCount text-center mb-0">
                                        <li><span>Suspected Words</span></li>
                                     
                                       <li><span><?php echo isset($average_accuracy) ?  round($average_accuracy) : 0 ;?>%</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <?php
                echo ListView::widget([
                    'dataProvider' => $recordDataProvider,
                    'itemView' => '_result',
                    'pager' => [
                        'prevPageLabel' => 'Previous',
                        'nextPageLabel' => 'Next',
                        'linkOptions' => ['class' => 'page-link'],
                        'activePageCssClass' => 'myactive page-item',
                        'disabledPageCssClass' => 'disabled page-item',
                        'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link']
                    ],

                ]);
                ?>
            </div>

        </section>
    </div>
</div>
