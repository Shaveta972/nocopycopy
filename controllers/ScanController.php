<?php
namespace app\controllers;

use app\models\UserRecords;
use app\models\UserRequest;
use app\models\User;
use Yii;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;
use yii\helpers\StringHelper;
use app\models\FileModelForm;
use yii\data\ActiveDataProvider;
use app\models\CreditScanSettings;
use app\models\Subjects;
use kartik\mpdf\Pdf;

class ScanController extends BaseController
{

    public $layout = 'inner-layout';

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ]
        ];
    }

    public function behaviors()
{
    return [
        'corsFilter' => [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                // restrict access to
                'Origin' => ['http://localhost:4200', 'http://localhost:4200','https://www.nocopycopy.ng/dist/','https://www.nocopycopy.ng', 'www.nocopycopy.ng/web'],
                // Allow only POST and PUT methods
                'Access-Control-Request-Method' => ['POST', 'PUT' ,'GET'],
                // Allow only headers 'X-Wsse'
                'Access-Control-Request-Headers' => ['X-Wsse'],
                // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
                'Access-Control-Allow-Credentials' => true,
                // Allow OPTIONS caching
                'Access-Control-Max-Age' => 3600,
                // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
            ],

        ],
    ];
}

    public function beforeAction($action)
    {
        if ($action->id === 'completed') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function getAccessToken()
    {
        $client = new \GuzzleHttp\Client([
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'verify' => false
        ]);
    
        $response = $client->request('POST', 'https://id.copyleaks.com/v3/account/login/api', [
            'body' => json_encode([
                'email' => Yii::$app->params['copyleaks_email'],
                "key" => Yii::$app->params['copyleaks_apikey']
            ])
        ]);

        $contents = $response->getBody()->getContents();
        $response = json_decode($contents);
        return $response->access_token;
    }

    public function actionSource($scan_id){
        $access_token = $this->getAccessToken();
        $client = new \GuzzleHttp\Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $access_token,
            ],
            'verify' => false
        ]);


        $response = $client->request('GET', 'https://api.copyleaks.com/v3/downloads/'.$scan_id);
        $contents = $response->getBody()->getContents();
        return $contents;
    }

    //Get Result Json from result id
    
    public function actionResultSource($scan_id,$rid){
        $access_token = $this->getAccessToken();
        $client = new \GuzzleHttp\Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $access_token
            ],
            'verify' => false
        ]);

        $response = $client->request('GET', 'https://api.copyleaks.com/v3/downloads/'.$scan_id.'/results/'.$rid);
        $contents = $response->getBody()->getContents();
        return $contents;
    }
    
     
    public function actionCompleteResult($scan_id){
        
        if($scan_id == null){
            throw new NotFoundHttpException(); 
        }
        $userRecord = UserRecords::findOne([
            'process_id' => $scan_id         
            ]);
        if ($userRecord === null) {
            throw new NotFoundHttpException();
        }

        $contents = $userRecord->results;
        $data = json_decode($contents);
        foreach($data->results->database as $item){
            $item->title = str_replace("Copyleaks internal database ","NoCopyCopy",$item->title);

        }
     
         return json_encode($data);
    }	
   

  
    public function actionResults($id)
    {
        $userRecord = UserRecords::findOne([
            'process_id' => $id         
        ]);
        if ($userRecord === null) {
            throw new NotFoundHttpException();
        }

        $client = new \GuzzleHttp\Client();
       
        $url= 'https://www.nocopycopy.ng/dist/?id='.$id;
        return $this->render('/scan/results', [
        'embed_report' => $url
            // 'recordDataProvider' => $recordDataProvider,
            // 'exportDataProvider' => $exportDataProvider,
            // 'user_request' => $userRecord,
            // 'redirect' => '0',
            // 'average_accuracy' => $average_accuracy,
            // 'count_records' => $count_records

        ]);
    }

    public function actionAjaxSendRequest()
    {
        try {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new UserRecords();  
            $userModel= new User();
            $id=Yii::$app->user->identity->id;
            $user_type = Yii::$app->user->identity->is_subadmin;
            $credit_account_type = Yii::$app->user->identity->credit_type;
            if (Yii::$app->request->isAjax) {
            
                if ($model->load(Yii::$app->request->post())) {
                    $getcredits= CreditScanSettings::find()->select('credit_value')->where(['doc_type' => $model->process_type])->one();
                    $credit_value= $getcredits->credit_value;
                    $account_type = Yii::$app->user->identity->credit_type;
                    $credit_type = Yii::$app->user->identity->credit_type;

                       
                    if ($user_type == User::TEACHER_SUBADMIN || $user_type == User::STAFF_SUBADMIN) {
                        if($credit_account_type == User::CREDITS_ALLOCATED) {
                            $allocatedCredits=  Yii::$app->user->identity->allocated_credits;
                            $credits= $userModel->getAllocatedRemainingCredits($id);
                            if($credits == 0 || $credits < $credit_value){
                                return [
                                    'data' => [
                                        'error' => true,
                                        'id' => '0',
                                        'redirect_uri' => 'saved1',
                                        'message' =>  "You don't have enough credits to complete the request. You need to   purchase credits in order to complete the request."
                                    ]
                                ];
                            }
                        }

                        if($credit_account_type == User::CREDITS_PERSONAL) {
                            $personalCredits =  $userModel->getPersonalCredits($id);
                            $credits= $userModel->getPersonalRemainingCredits($id);
                            if($credits == 0 || $credits < $credit_value){
                                return [
                                    'data' => [
                                        'error' => true,
                                        'id' => '0',
                                        'redirect_uri' => 'saved1',
                                        'message' =>  'You have no credits. You need to purchase credits in order to complete the request'
                                    ]
                                ];
                            }
                        }
                    }



            if (Yii::$app->user->identity->is_subadmin == User::STUDENT_SUBADMIN) {
                // echo $model->subject_code;
                if (isset($model->subject_code) && (!empty($model->subject_code))) {
                    $checkSubjectCode= Subjects::find()->where(['subject_code'=> $model->subject_code])->one();
                    if (!$checkSubjectCode) {
                        return [
                        'data' => [
                            'error' => true,
                            'id' => '0',
                            'redirect_uri' => 'null',
                            'message' =>  'Please enter valid subject code.'
                        ]
                    ];
                    } else {
                        $account_type = Yii::$app->user->identity->account_type;
                        $credit_type = Yii::$app->user->identity->credit_type;
                    }
                } else {
                    $account_type = User::CREDITS_PERSONAL;
                    $credit_type = User::CREDITS_PERSONAL;
                }
            }
                
           
            if (Yii::$app->user->identity->parent_id == 0 ) {
                if($credit_account_type == User::CREDITS_PERSONAL) {
                   $credits= $userModel->sumParentCredits($id);
                   $remaining_credits= $userModel->getParentRemainingCredits($id);
                    if($remaining_credits == 0 || $remaining_credits < $credit_value){
                        return [
                            'data' => [
                                'error' => true,
                                'id' => '0',
                                'redirect_uri' => 'saved1',
                                'message' =>  "You don't have enough credits to complete the request. You need to   purchase credits in order to complete the request."
                            ]
                        ];
                    }
                }
            }

                    $access_token = $this->getAccessToken();
                    if (! empty($access_token)) {
                        $client = new \GuzzleHttp\Client([
                            'headers' => [
                                'Content-Type' => 'application/json',
                                'Authorization' => 'Bearer ' . $access_token
                               // 'copyleaks-sandbox-mode',
                                //'copyleaks-http-completion-callback' => \Yii::$app->params['WEB_URL'] . 'scan/completed?pid={PID}'
                            ],
                            'verify' => false
                        ]);

                        if ($model->process_type == 'text') {
                            $response = $client->request('POST', 'https://api.copyleaks.com/v1/education/create-by-text', [
                                'body' => $model->process_value
                            ]);
                        }

                        if ($model->process_type == 'url') {
                            $ProcessId= "results".strtotime("now");
                               $response = $client->request('PUT', 'https://api.copyleaks.com/v3/education/submit/url/'.$ProcessId , [
                                'body' => json_encode([
                                    'url' => $model->process_value,
                                      "properties" =>[
                                            "sandbox" => true,
                                            "includeHtml" => true,
                                            "pdf" => [
                                                "create" => true,
                                                "title" => 'my_report',
                                                "largeLogo" => 'data:image/png;base64,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'

                                            ],
                                            "exclude" => [
                                                  "quotes" => true,
                                                  "titles" => true,
                                                //  "htmlTemplate" => false
                                                ],
                                            // "sensitivityLevel" => 3,
                                            "webhooks" => [
                                                    "status" => \Yii::$app->params['WEB_URL'] ."scan/{STATUS}/".$ProcessId
                                                ]
                                             ]
                                        ])
                                     ]);
                           }

                        if ($response->getStatusCode() == 201) {
                            $contents = $response->getBody()->getContents();
                            $response = json_decode($contents);
                            if (! empty($ProcessId)) {
                                $userRecord = new UserRecords();
                                $userRecord->user_id = Yii::$app->user->id;
                                $userRecord->subject_code = isset($model->subject_code) ? $model->subject_code : null;
                                $userRecord->process_id = $ProcessId;
                                $userRecord->process_type = $model->process_type;
                                $userRecord->process_value = $model->process_value;
                                $userRecord->user_id = Yii::$app->user->id;
                                $userRecord->credit_used= 0;
                                $userRecord->account_type= $account_type;
                                $userRecord->credit_type=  $credit_type;
                                if ($userRecord->save()) {
                                    return [
                                        'data' => [
                                            'success' => true,
                                            'id' => $ProcessId,
                                            'message' => 'Model has been saved.'
                                        ],
                                        'code' => '0'
                                    ];
                                } else {
                                    return [
                                        'data' => [
                                            'error' => true,
                                            'id' => '0',
                                            'redirect_uri' => 'null',
                                            'message' =>  $userRecord->getFirstErrors()
                                        ]
                                    ];
                                }
                            } else {
                                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Something went wrong. Please try again later.'));
                                return [
                                    'data' => [
                                        'error' => true,
                                        'id' => '0',
                                        'redirect_uri' => 'null',
                                        'message' => 'No Request Created.'
                                    ],
                                    'code' => '0'
                                ];
                            }
                        }
                        else{
                            return [
                                'data' => [
                                    'error' => true,
                                    'id' => '0',
                                    'redirect_uri' => 'null',
                                    'message' => 'An error occured77.'
                                ],
                                'code' => $response
                            ];
                        }
                    } else {
                        return [
                            'data' => [
                                'error' => true,
                                'id' =>'0',
                                'redirect_uri' => 'null',
                                'message' => 'An error occured78.'
                            ],
                            'code' => 0 
                        ];
                    }
                }
            }
        } catch (\Exception $e) {
           // \Yii::$app->session->setFlash('error', \Yii::t('app', $e->getMessage()) );
            return [
                'data' => [
                    'error' => true,
                    'id' => '0',
                    'redirect_uri' => 'null',
                    'message' => 'Something went wrong, Please try again later',
                    'exception_message' => \Yii::t('app', $e->getMessage())
                ],
                'code' => $e->getCode()
            ];
        }
    }

    public function actionProcess(){
        return $this->render('/scan/results');
    }

    
    public function actionError(){
     $errorData = file_get_contents('php://input');
     $resultData= json_decode($postedData, true);   
    }
    public function actionCompleted()
    {
        $postedData = file_get_contents('php://input');
        $resultData= json_decode($postedData, true);
        $scan_id= $resultData['scannedDocument']['scanId'];
        \Yii::$app->response->format = 'json';
        $userRecord = UserRecords::findOne([
            'process_id' => $scan_id
        ]);

        if ($userRecord === null) {
            return [
                'status' => "NOK",
                'message' => "User Record not found"
            ];
        }

        if ($userRecord->state_id === UserRecords::STATE_COMPLETED) {
            return [
                'status' => "NOK",
                'message' => "Record already processed"
            ];
        }

           if (isset($resultData['results'])) {
                $result = $resultData['results']['internet'];
                if ($result) {
            
                    foreach ($result as $data) {
                            \Yii::warning('****** CHUNKED DATA ******** '.VarDumper::dumpAsString($data['id']));
                            $userRequest = new UserRequest();
                            $userRequest->result_id= $data['id'];
                            $userRequest->process_id = $scan_id;
                            $userRequest->url = $data['url'];
                            $userRequest->number_copied_words = $data['matchedWords'];
                            $userRequest->title = $data['title'];
                            $userRequest->introduction = $data['introduction'];                        
                            if (! $userRequest->save()) {
                                \Yii::error('****** error while saving the user request ******** ' . VarDumper::dumpAsString($userRequest->errors));
                            }
                    }
                   $jsondata= json_encode($resultData);
                   $userRecord->results = $jsondata;
                   $userRecord->total_results = $resultData['scannedDocument']['totalWords'];
                   $userRecord->credit_used = $resultData['scannedDocument']['credits'];
                   $userRecord->state_id = UserRecords::STATE_COMPLETED;
                
                if (! $userRecord->save()) {
                        \Yii::error('****** error while saving the user records ******** ' . VarDumper::dumpAsString($userRecord->errors));
                    }
                } else {
                    \Yii::error('****** no results found ******** ');
                    $userRecord->results = $jsondata;
                    $userRecord->total_results = $resultData['scannedDocument']['totalWords'];
                    $userRecord->credit_used = $resultData['scannedDocument']['credits'];
                    $userRecord->state_id = UserRecords::STATE_COMPLETED;
                    if (! $userRecord->save()) {
                        \Yii::error('****** error while saving the user records ******** ' . VarDumper::dumpAsString($userRecord->errors));
                    }
                }
            } else {

                return [
                    'status' => "NOK"
                ];
            }
        
         \Yii::$app->session->setFlash('success', \Yii::t('app', 'Records are available now. Please check'));
        return [
            'status' => "OK"
        ];
    }

    public function actionProcessFile()
    {
        \Yii::$app->response->format = 'json';
       
        $userModel= new User();
        $account_type = Yii::$app->user->identity->account_type;
        $credit_type = Yii::$app->user->identity->credit_type;

        $model = new FileModelForm();
        if ($model->load(\Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $fileName = $model->upload();
            $getcredits= CreditScanSettings::find()->select('credit_value')->where(['doc_type' => $model->process_type])->one();
            $credits= $getcredits->credit_value;
            $account_type = Yii::$app->user->identity->account_type;
            $credit_type = Yii::$app->user->identity->credit_type;
           if ($fileName) {
                $access_token = $this->getAccessToken();
                $path=\Yii::getAlias('@uploads') . '/' . $fileName;
                $data = file_get_contents($path);
                $base64 = base64_encode($data);
                 
                $client = new \GuzzleHttp\Client([
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $access_token,
                    ],
                    'verify' => false
                ]);
                
                $ProcessId= "test".strtotime("now");
                   $response = $client->request('PUT', 'https://api.copyleaks.com/v3/education/submit/file/'.$ProcessId , [
                    'body' => json_encode([
                       'base64' => $base64,
                        'filename' => $fileName,
                                       "properties" =>[
                                            "sandbox" => false,
                                            "includeHtml" => true,
                                            "pdf" => [
                                                "create" => true,
                                                "title" => $ProcessId,
                                                "largeLogo" => 'data:image/png;base64,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'

                                            ],
                                            "exclude" => [
                                                  "quotes" => true,
                                                  "titles" => true,
                                                //  "htmlTemplate" => false
                                                ],
                                            // "sensitivityLevel" => 3,
                                            "webhooks" => [
                                                    "status" => \Yii::$app->params['WEB_URL'] ."scan/{STATUS}/".$ProcessId
                                                ]
                                             ]
                        //   "properties" =>[
                        //       // "sandbox" => true,
                        //         "webhooks" => [
                        //                 "status" => \Yii::$app->params['WEB_URL'] ."scan/{STATUS}/".$ProcessId
                        //             ]
                        //          ]
                            ])
                         ]);

                if ($response->getStatusCode() == 201) {
                      $userRecord = new UserRecords();
                                $userRecord->user_id = Yii::$app->user->id;
                                $userRecord->subject_code = isset($model->subject_code) ? $model->subject_code : null;
                                $userRecord->process_id = $ProcessId;
                                $userRecord->process_type = $model->process_type;
                                $userRecord->process_value = $fileName;
                                $userRecord->user_id = Yii::$app->user->id;
                                $userRecord->credit_used= 0;
                                $userRecord->account_type= $account_type;
                                $userRecord->credit_type=  $credit_type;
                    if ($userRecord->save()) {
                      return [
                        'data' => [
                            'success' => true,
                            'id' =>'1',
                            'message' => 'File Upload Successfully.',
                            'status' => 'OK'
                        ]
                    ];
                }
                } else {
                    return [
                        'data' => [
                            'error' => true,
                            'id' =>'0',
                            'message' => 'Something went wrong',
                            'status' => 'NOK'
                        ]
                    ];
                }
            } else {
                return [
                    'data' => [
                        'error' => true,
                        'id' =>'0',
                        'message' => $model->getFirstError('file'),
                        'status' => 'NOK'
                    ]
                ];
               // \Yii::$app->session->setFlash('error', $model->getFirstError('file'));
            }
        } else {

            return [
                'data' => [
                    'error' => true,
                    'id' =>'0',
                    'message' => \Yii::t('app', 'Please upload a file'),
                    'status' => 'NOK'
                ]
            ];

         //   \Yii::$app->session->setFlash('error', \Yii::t('app', 'Please upload a file'));
        }

        return [
            'status' => 'OK'
        ];
    }

    public function actionTextScan()
    {
        $model = new UserRecords(['scenario' => 'text']);
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
           
                Yii::$app->response->format = Response::FORMAT_JSON;
                $err = ActiveForm::validate($model);
                return $err;
            }
        return $this->renderAjax('textScan', [
            'model' => $model
        ]);
    }

    public function actionFileScan()
    {
        $model = new FileModelForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        return $this->renderAjax('fileScan', [
            'model' => $model
        ]);
    }

    public function actionUrlScan()
    {

        $model = new UserRecords(['scenario' => 'url']);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $err = ActiveForm::validate($model);
        }
        return $this->renderAjax('urlScan', [
            'model' => $model
        ]);
    }


}