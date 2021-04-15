<?php
namespace app\controllers;

// use app\models\UserRecords;
// use app\models\UserRequest;
use Yii;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;
use yii\helpers\StringHelper;
use app\models\FileModelForm;
use yii\data\ActiveDataProvider;
use app\models\ScanRequest;
use app\models\ScanRecords;
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
        $response = $client->request('POST', 'https://api.copyleaks.com/v1/account/login-api', [
            'body' => json_encode([
                'Email' => Yii::$app->params['copyleaks_email'],
                "ApiKey" => Yii::$app->params['copyleaks_apikey']
            ])
        ]);
        $contents = $response->getBody()->getContents();
        $response = json_decode($contents);
        return $response->access_token;
    }

    public function actionResults($id)
    {
        $userScanRequest = ScanRequest::findOne([
            'process_id' => $id
        ]);

        if ($userScanRequest === null) {
            throw new NotFoundHttpException();
        }

        $recordDataProvider = new ActiveDataProvider([
            'query' => ScanRecords::find()->where([
                'process_id' => $id
            ]),
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);
        
        $exportDataProvider = new ActiveDataProvider([
            'query' => ScanRecords::find()->where([
                'process_id' => $id
            ]),
            'pagination'=>false
        ]);
        
        return $this->render('/scan/results', [
            'recordDataProvider' => $recordDataProvider,
            'exportDataProvider' => $exportDataProvider,
            'user_request' => $userScanRequest,
            'redirect' => '0'
        ]);
    }

    public function actionAjaxSendRequest()
    {
        try {
            $model = new ScanRequest();
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                if ($model->load(Yii::$app->request->post())) {
                    $access_token = $this->getAccessToken();
                    if (! empty($access_token)) {
                        $client = new \GuzzleHttp\Client([
                            'headers' => [
                                'Content-Type' => 'application/json',
                                'Authorization' => 'Bearer ' . $access_token,
                                'copyleaks-http-completion-callback' => \Yii::$app->params['WEB_URL'] . 'scan/completed?pid={PID}'
                            ],
                            'verify' => false
                        ]);

                        if ($model->process_type == 'text') {
                            $response = $client->request('POST', 'https://api.copyleaks.com/v1/education/create-by-text', [
                                'body' => $model->process_value
                            ]);
                        }
                        if ($model->process_type == 'url') {
                            $response = $client->request('POST', 'https://api.copyleaks.com/v1/education/create-by-url', [
                                'body' => json_encode([
                                    'Url' => $model->process_value
                                ])
                            ]);
                        }
                        // if ($response->getStatusCode() == 404) {
                        //     echo "<pre>";
                        //     print_r($response);
                        //     echo "</pre>";
                        //     die();
                        //  //   ${exit();}
                        // }

                        if ($response->getStatusCode() == 200) {
                            $contents = $response->getBody()->getContents();
                            $response = json_decode($contents);
                            if (! empty($response->ProcessId)) {
                                $userRecord = new ScanRequest();
                                $userRecord->user_id = Yii::$app->user->id;
                                $userRecord->process_id = $response->ProcessId;
                                $userRecord->process_type = $model->process_type;
                                $userRecord->process_value = StringHelper::truncate($model->process_value, 512);
                                if ($userRecord->save()) {
                                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Your request has been processed. Please wait for a while'));
                                    return [
                                        'data' => [
                                            'success' => true,
                                            'id' => $response->ProcessId,
                                            'message' => 'Model has been saved.'
                                        ],
                                        'code' => '0'
                                    ];
                                } else {
                                    \Yii::$app->session->setFlash('error', \Yii::t($userRecord->getFirstErrors()));
                                    return [
                                        'data' => [
                                            'error' => true,
                                            'id' => null,
                                            'redirect_uri' => 'null',
                                            'message' => 'Record Not Saved.'
                                        ]
                                    ];
                                }
                            } else {
                                \Yii::$app->session->setFlash('error', \Yii::t('app', 'Something went wrong. Please try again later.'));
                                return [
                                    'data' => [
                                        'error' => true,
                                        'id' => null,
                                        'redirect_uri' => 'null',
                                        'message' => 'No Process Created.'
                                    ],
                                    'code' => '0'
                                ];
                            }
                        }
                    } else {
                        return [
                            'data' => [
                                'error' => true,
                                'id' => null,
                                'redirect_uri' => 'null',
                                'message' => '$userRecord->getFirstErrors()'
                            ],
                            'code' => '0'
                        ];
                    }
                }
            }
        } catch (\Exception $e) {
            \Yii::$app->session->setFlash('error', \Yii::t('app', $e->getMessage()));
            return [
                'data' => [
                    'error' => true,
                    'id' => null,
                    'redirect_uri' => 'null',
                    'message' => 'An error occured.'
                ],
                'code' => '0'
            ];
        }
    }

    public function actionCompleted($pid)
    {
        \Yii::$app->response->format = 'json';
        $userRecord = ScanRequest::findOne([
            'process_id' => $pid
        ]);

        if ($userRecord === null) {
            return [
                'status' => "NOK",
                'message' => "User Record not found"
            ];
        }

        if ($userRecord->state_id === ScanRequest::STATE_COMPLETED) {
            return [
                'status' => "NOK",
                'message' => "Record already processed"
            ];
        }

        $access_token = $this->getAccessToken();
        $client = new \GuzzleHttp\Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $access_token
            ],
            'verify' => false
        ]);

        $response = $client->request('GET', 'https://api.copyleaks.com/v2/education/' . $pid . '/result');
        if ($response->getStatusCode() == 200) {
            $body = $response->getBody();
            $data = json_decode($body, true);
            \Yii::warning('****** PARSED REPONSE ******** ' . VarDumper::dumpAsString($data));
            if (isset($data['results'])) {
                $data = array_chunk($data['results'], 100);
                if ($data) {
                    \Yii::warning('****** CHUNKED DATA ******** '.VarDumper::dumpAsString($data[0]));
                    foreach ($data[0] as $result) {
                        $scanRecords = new ScanRecords();
                        $scanRecords->process_id = $userRecord->process_id;
                        $scanRecords->url = $result['url'];
                        $scanRecords->percents = (string) $result['totalMatchedPercents'];
                        $scanRecords->number_copied_words = $result['totalMatchedWords'];
                        $scanRecords->cached_version = $result['report'];
                        $scanRecords->title = $result['title'];
                        $scanRecords->introduction = StringHelper::truncate($result['introduction'], 512);
                        if (! $scanRecords->save()) {
                            \Yii::error('****** error while saving the user request ******** ' . VarDumper::dumpAsString($scanRecords->errors));
                        }
                    }
                    $userRecord->total_results = count($data[0]);
                    $userRecord->state_id = ScanRequest::STATE_COMPLETED;
                    if (! $userRecord->save()) {
                        \Yii::error('****** error while saving the user records ******** ' . VarDumper::dumpAsString($userRecord->errors));
                    }
                } else {
                    \Yii::error('****** no results found ******** ');
                    $userRecord->state_id = ScanRequest::STATE_COMPLETED;
                    if (! $userRecord->save()) {
                        \Yii::error('****** error while saving the user records ******** ' . VarDumper::dumpAsString($userRecord->errors));
                    }
                }
            } else {
                return [
                    'status' => "NOK"
                ];
            }
        }

        return [
            'status' => "OK"
        ];
    }

    public function actionProcessFile()
    {
        \Yii::$app->response->format = 'json';
        $model = new FileModelForm();
        if ($model->load(\Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $fileName = $model->upload();
            if ($fileName) {
                $access_token = $this->getAccessToken();
                $client = new \GuzzleHttp\Client([
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $access_token,
                        'copyleaks-http-completion-callback' => \Yii::$app->params['WEB_URL'] . 'scan/completed?pid={PID}'
                    ],
                    'verify' => false
                ]);

                $response = $client->request('POST', 'https://api.copyleaks.com/v1/education/create-by-file', [
                    'multipart' => [
                        [
                            'name' => 'FileContents',
                            'contents' => file_get_contents(\Yii::getAlias('@uploads') . '/' . $fileName),
                            'filename' => $fileName
                        ]
                    ]
                ]);

                if ($response->getStatusCode() == 200) {
                    $body = $response->getBody();
                    $data = json_decode($body);
                    $userRecord = new ScanRequest();
                    $userRecord->user_id = Yii::$app->user->id;
                    $userRecord->process_id = $data->ProcessId;
                    $userRecord->process_type = $model->process_type;
                    $userRecord->process_value = $fileName;
                    $userRecord->user_id = Yii::$app->user->id;

                    if ($userRecord->save()) {
                        \Yii::$app->session->setFlash('success', \Yii::t('app', 'Your request has been submitted'));
                        return [
                            'status' => 'OK'
                        ];
                    }
                } else {
                    \Yii::$app->session->setFlash('error', \Yii::t('app', 'Something went wrong'));
                    return [
                        'status' => 'OK'
                    ];
                }
            } else {
                \Yii::$app->session->setFlash('error', $model->getFirstError('file'));
            }
        } else {
            \Yii::$app->session->setFlash('error', \Yii::t('app', 'Please upload a file'));
        }

        return [
            'status' => 'OK'
        ];
    }

    public function actionTextScan()
    {
        $model = new ScanRequest();
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
        $model = new ScanRequest();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $err = ActiveForm::validate($model);
        }
        return $this->renderAjax('urlScan', [
            'model' => $model
        ]);
    }
}