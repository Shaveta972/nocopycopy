<?php
namespace app\controllers;

use Yii;
use app\models\User;
use app\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use app\models\SendReferalCodeForm;
use yii\data\ActiveDataProvider;
use app\models\UserRecords;
use app\models\ChangePasswordForm;
use app\models\UserPlans;
use app\models\UserCategories;
use app\models\Subjects;
use app\models\UserRequest;
use app\models\UserApproveForm;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseController
{
    public $layout = 'inner-layout';

    /**
     *
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'login',
                            'register'
                        ],
                        'roles' => [
                            '?'
                        ]
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'logout',
                            'profile',
                            'dashboard',
                            'details',
                            'update',
                            'referals',
                            'send-invitation-link',
                            'change-password',
                            'transaction-history',
                            'approve',
                            'switch',
                            'subject',
                            'assignments',
                            'uploads',
                            'download',
                            'transactions',
                            'settings',
                            'lecturers',
                            'students',
                            'members',
                            ''
                        ],
                        'roles' => [
                            '@'
                        ]
                    ]
                ]
            ]
        ];
    }

    
    /**
     * Displays a single User model.
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionProfile($id)
    {
        try {
            $this->layout = 'inner-layout';
            Yii::setAlias("@imagesUrl", "@web/uploads");
            $dataProvider = new ActiveDataProvider([
                'query' => UserPlans::find()->select('
                tbl_user_plans.expiration_date,
                tbl_user_plans.created_at,
                tbl_user_plans.is_cancel,
                tbl_user_plans.status,
                tbl_user_plans.isExpire,
                tbl_user_plans.reference_id,
                tbl_transactions.amount_paid,
                tbl_transactions.created_at'
                )->leftJoin('tbl_transactions', '`tbl_transactions`.`reference_id` = `tbl_user_plans`.`reference_id`')
                ->where(['user_id' => Yii::$app->user->getId()])
                ->andWhere(['tbl_user_plans.status' => 1]),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
            
            $userModel = $this->findModel($id);
            $getCategoryData = UserCategories::find()->where(['id' => $userModel->user_category_id])->one();
        
            return $this->render("profile", array(
            'dataProvider' => $dataProvider,
            'model' => $this->findModel($id),
            'userModel' => $userModel,
        
            ));
        } catch (InvalidParamException $e) {
            throw new \yii\web\BadRequestHttpException($e->getMessage());
        }
    }
    public function actionStudents($id)
    {
        try {
            $this->layout = 'inner-layout';
            Yii::setAlias("@imagesUrl", "@web/uploads");
           
            $referralStudentdataProvider = new ActiveDataProvider([
                'query' => User::find()->where([
                    'parent_id' => $id,
                    'is_confirmed' => User::EMAIL_CONFIRM,
                    'is_subadmin' => User::STUDENT_SUBADMIN
                ])
                    ->orderBy([
                        'id' => SORT_DESC
                    ]),
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]);
        
            return $this->render("students", array(
            'referralStudentdataProvider' => $referralStudentdataProvider
            ));
        } catch (InvalidParamException $e) {
            throw new \yii\web\BadRequestHttpException($e->getMessage());
        }
    }
    public function actionLecturers($id)
    {
        try {
            $this->layout = 'inner-layout';
            Yii::setAlias("@imagesUrl", "@web/uploads");
           
            $referralLecturerdataProvider = new ActiveDataProvider([
                'query' => User::find()->where([
                    'parent_id' => $id,
                    //  'is_confirmed' => User::EMAIL_CONFIRM,
                     'is_subadmin' => User::TEACHER_SUBADMIN
                ])
                    ->orderBy([
                        'id' => SORT_DESC
                    ]),
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]);

    
            /**
             * Referral Code Ends
             */
            return $this->render("lecturers", array(
            'referralLecturerdataProvider' => $referralLecturerdataProvider
            ));
        } catch (InvalidParamException $e) {
            throw new \yii\web\BadRequestHttpException($e->getMessage());
        }
    }
    public function actionMembers($id)
    {
        try {
            $this->layout = 'inner-layout';
            Yii::setAlias("@imagesUrl", "@web/uploads");
           
            $referralStaffdataProvider = new ActiveDataProvider([
                'query' => User::find()->where([
                    'parent_id' => $id,
                    //  'is_confirmed' => User::EMAIL_CONFIRM,
                     'is_subadmin' => User::STAFF_SUBADMIN
                ])
                    ->orderBy([
                        'id' => SORT_DESC
                    ]),
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]);

    
            /**
             * Referral Code Ends
             */
            return $this->render("members", array(
            'referralStaffdataProvider' => $referralStaffdataProvider
            ));
        } catch (InvalidParamException $e) {
            throw new \yii\web\BadRequestHttpException($e->getMessage());
        }
    }
    public function actionSettings($id)
    {
        try {
            Yii::setAlias("@imagesUrl", "@web/uploads");
            $this->layout = 'inner-layout';
            $changePasswordModel = new ChangePasswordForm($id);
            if ($changePasswordModel->load(\Yii::$app->request->post())) {
                if ($changePasswordModel->validate() && $changePasswordModel->changePassword()) {
                    \Yii::$app->session->setFlash('success', 'Password Changed Successfully!');
                    return $this->refresh();
                } else {
                }
            }
            return $this->render("settings", array(
            'changePasswordModel' => $changePasswordModel,
            
            ));
        } catch (InvalidParamException $e) {
            throw new \yii\web\BadRequestHttpException($e->getMessage());
        }
    }
    public function actionTransactions($id)
    {
        try {
            $this->layout = 'inner-layout';
            Yii::setAlias("@imagesUrl", "@web/uploads");
            $dataProvider = new ActiveDataProvider([
                'query' => UserPlans::find()->select('
                tbl_user_plans.expiration_date,
                tbl_user_plans.created_at,
                tbl_user_plans.is_cancel,
                tbl_user_plans.status,
                tbl_user_plans.isExpire,
                tbl_user_plans.reference_id,
                tbl_transactions.amount_paid,
                tbl_transactions.created_at'
                )->leftJoin('tbl_transactions', '`tbl_transactions`.`reference_id` = `tbl_user_plans`.`reference_id`')
                ->where(['user_id' => Yii::$app->user->getId()])
                ->andWhere(['tbl_user_plans.status' => 1]),
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]);
            
            $changePasswordModel = new ChangePasswordForm($id);
            if ($changePasswordModel->load(\Yii::$app->request->post())) {
                if ($changePasswordModel->validate() && $changePasswordModel->changePassword()) {
                    \Yii::$app->session->setFlash('success', 'Password Changed Successfully!');
                    return $this->refresh();
                } else {
                }
            }
          
            $userModel = $this->findModel($id);
            $getCategoryData = UserCategories::find()->where(['id' => $userModel->user_category_id])->one();
            /**
             * Referrals Code starts
             */
            $referralLecturerdataProvider = new ActiveDataProvider([
                'query' => User::find()->where([
                    'parent_id' => $id,
                    'is_confirmed' => User::EMAIL_CONFIRM,
                    'is_subadmin' => User::TEACHER_SUBADMIN
                ])
                    ->orderBy([
                        'id' => SORT_DESC
                    ]),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);

            /**
             * Referrals Code starts
             */
            $referralStudentdataProvider = new ActiveDataProvider([
                'query' => User::find()->where([
                    'parent_id' => $id,
                    'is_confirmed' => User::EMAIL_CONFIRM,
                    'is_subadmin' => User::STUDENT_SUBADMIN
                ])
                    ->orderBy([
                        'id' => SORT_DESC
                    ]),
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]);
          //  echo  User::EMAIL_CONFIRM;
          //  die();
            

            $referralStaffdataProvider = new ActiveDataProvider([
                'query' => User::find()->where([
                    'parent_id' => $id,
                    //  'is_confirmed' => User::EMAIL_CONFIRM,
                     'is_subadmin' => User::STAFF_SUBADMIN
                ])
                    ->orderBy([
                        'id' => SORT_DESC
                    ]),
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]);

                 $subjectsdataProvider = new ActiveDataProvider([
                'query' => Subjects::find()->where(['user_id' => $id])
                    ->orderBy([
                        'id' => SORT_DESC
                    ]),
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]);

            $uploadedAssignmentsdataProvider = new ActiveDataProvider([
                'query' => UserRecords::find()->where([
                    'user_id' => $id
    
                ])->andWhere(['not', ['subject_code' => null]])
                    ->orderBy([
                        'id' => SORT_DESC
                    ]),
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]);
    
            /**
             * Referral Code Ends
             */
            return $this->render("transactions", array(
            'dataProvider' => $dataProvider,
            'model' => $this->findModel($id),
            'userModel' => $userModel,
            'getCategoryData' => $getCategoryData,
            'changePasswordModel' => $changePasswordModel,
          
            'uploadedAssignmentsdataProvider' =>$uploadedAssignmentsdataProvider,
            ));
        } catch (InvalidParamException $e) {
            throw new \yii\web\BadRequestHttpException($e->getMessage());
        }
    }

    /**
     * 
     */

     public function actionAssignments($subject_code){
        $this->layout = 'inner-layout';
        Yii::setAlias("@imagesUrl", "@web/uploads");
        $query=UserRecords::find()
        ->joinWith('user u')
        ->where([
            'subject_code' => $subject_code
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy([
                    'tbl_user_records.id' => SORT_DESC
                ]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render("assignments", array(
            'dataProvider' => $dataProvider,
            'subject_code' => $subject_code,
            
        ));
           
     }
     public function actionUploads($id){
        $this->layout = 'inner-layout';
        Yii::setAlias("@imagesUrl", "@web/uploads");
        $uploadedAssignmentsdataProvider = new ActiveDataProvider([
            'query' => UserRecords::find()->where([
                'user_id' => $id

            ])->andWhere(['not', ['subject_code' => null]])
                ->orderBy([
                    'id' => SORT_DESC
                ]),
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);
        return $this->render("uploads", array(
            'uploadedAssignmentsdataProvider' => $uploadedAssignmentsdataProvider,
           
            
        ));
           
     }
    /**
     * Displays a Referral Details User model.
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDetails($id)
    {
        $this->layout = 'inner-layout';
        Yii::setAlias("@imagesUrl", "@web/uploads");
        $planCredits = 0;
        $userModel = new User();
        $planModel =  UserPlans::find()->where(['user_id' => $id])->with('plans')->andWhere(['isExpire' => 0])->andWhere(['is_cancel' => 0])->andWhere(['status' => 1])->one();
        if ($planModel) {
            $planCredits = $planModel->credits;
        }
        $userdata= User::findOne($id);
        $totalCredits = $userModel->getTotalCredits();
        $remaining_business_credits = $userdata->business_credits;
        $remaining_personal_credits =  $planCredits +  $userdata->personal_credits;
        $bcredits_used = 0;
        $pcredits_used = 0;
        if ($userdata->parent_id > 0) {
            $pcredits_used = UserRecords::find()->where(['user_id' => $id, 'account_type' => 1])->sum('credit_used');
            $remaining_personal_credits =  ($userdata->personal_credits +  $planCredits)  - $pcredits_used;
            $bcredits_used = UserRecords::find()->where(['user_id' => $id, 'account_type' => 2])->sum('credit_used');
            $remaining_business_credits =  $userdata->business_credits - $bcredits_used;
        } else {
            $pcredits_used = UserRecords::find()->where(['user_id' => $id, 'account_type' => 1])->sum('credit_used');
            $business_credit_assigned = User::find()->where(['parent_id' => $id])->sum('business_credits');
            $remaining_personal_credits =  $totalCredits - ($pcredits_used + $business_credit_assigned);
            $pcredits_used= $pcredits_used + $business_credit_assigned;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => UserRecords::find()->where([
                'user_id' => $id
            ])
                ->orderBy([
                    'id' => SORT_DESC
                ]),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
       
        return $this->render("referraldetails", array(
            'dataProvider' => $dataProvider,
            'model' => $this->findModel($id),
            'planmodel' => $planModel,
            'bcredits_used' => $bcredits_used,
            'pcredits_used' => $pcredits_used,
            'planCredits' => $planCredits,
            'totalCredits' => $totalCredits,
            'remaining_personal_credits' => $remaining_personal_credits,
            'remaining_business_credits' => $remaining_business_credits,
        ));
    }



    /**
     * Displays a single User model.
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDashboard()
    {
        $this->layout = 'inner-layout';
        Yii::setAlias("@imagesUrl", "@web/uploads");
        $id = Yii::$app->user->getId();
        $planCredits = 0;
        $userModel = new User();
        $planModel =  UserPlans::find()->where(['user_id' => $id])->with('plans')->andWhere(['isExpire' => 0])->andWhere(['is_cancel' => 0])->andWhere(['status' => 1])->one();
        if ($planModel) {
            $planCredits = $planModel->credits;
        }
        $creditData=[];
        $pcredits_used=0;
        $allocated_used_credits=0;
        $remaining_personal_credits=0;
        $remaining_business_credits=0;
        $admin_used_credits=0;
        
        $totalCredits = $userModel->getTotalCredits();
        $personal_credits =  $planCredits +  Yii::$app->user->identity->personal_credits;

        if (Yii::$app->user->identity->parent_id > 0) {
            $pcredits_used = UserRecords::find()->where(['user_id' => $id, 'credit_type' => User::CREDITS_PERSONAL])->sum('credit_used');
            $remaining_personal_credits =  $personal_credits  - $pcredits_used;
            
            $allocated_used_credits = UserRecords::find()->where(['user_id' => $id, 'credit_type' => User::CREDITS_ALLOCATED])->sum('credit_used');
            $remaining_business_credits =  Yii::$app->user->identity->allocated_credits - $allocated_used_credits;
        
            $admin_used_credits = UserRecords::find()->where(['user_id' => $id, 'credit_type' => User::CREDITS_BUSINESS])->sum('credit_used');
          
        } 
            else if (Yii::$app->user->identity->parent_id == 0 && empty( Yii::$app->user->identity->referal_code )) {
            $pcredits_used = UserRecords::find()->where(['user_id' => $id, 'credit_type' => User::CREDITS_PERSONAL])->sum('credit_used');
            $remaining_personal_credits =  $personal_credits  - $pcredits_used;
            }
        else {
           
            $creditData['allocatedCredits'] = User::find()->where(['parent_id' => $id])->sum('allocated_credits'); // parent has allocated to  team members
            $creditData['selfUsedCredits'] = UserRecords::find()->where(['user_id' => $id])->sum('credit_used'); // parent self used credits
            $creditData['parentCreditsUsedbyTeamMembers'] = User::find()   // parent credits used by its referrals
            ->innerJoin('tbl_user_records', 'tbl_user.id = tbl_user_records.user_id')
            ->andWhere(['tbl_user.parent_id' => $id])
            ->andWhere(['tbl_user_records.credit_type' => User::CREDITS_BUSINESS])
            ->sum('credit_used');
         
             $creditData['totalCreditsUsed'] = $userModel->sumParentCredits($id);
             $creditData['totalCredits'] = $totalCredits;
             $creditData['remainingCredits'] = $totalCredits - $creditData['totalCreditsUsed'] ;

        }
        $countScans = UserRecords::find()->where([
            'user_id' => $id
            ])->count();
  
        $dataProvider = new ActiveDataProvider([
            'query' => UserRecords::find()->where([
                'user_id' => $id
                ])
                ->andWhere(['subject_code' => null])
                ->orderBy([
                    'id' => SORT_DESC
                ]),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        
        return $this->render("dashboard", array(
            'count_scans' => $countScans,
            'dataProvider' => $dataProvider,
            'model' => $this->findModel($id),
            'planmodel' => $planModel,
            'allocated_used_credits' => $allocated_used_credits,
            'pcredits_used' => $pcredits_used,
            'planCredits' => $planCredits,
            'totalCredits' => $totalCredits,
            'remaining_personal_credits' => $remaining_personal_credits,
            'remaining_business_credits' => $remaining_business_credits,
            'creditData'=> $creditData,
            'personal_credits'=> $personal_credits,
            'admin_used_credits'=> $admin_used_credits
        ));
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
     //   print_r(Yii::$app->request->post());
        //die();
        $this->layout = 'inner-layout';
        Yii::setAlias("@imagesUrl", "@web/uploads");
        $model = $this->findModel($id);
        // print_r($model);
        // die();
        $model->scenario = 'update';
        $oldprofilepic = $model->profile_picture;
        if ($model->load(Yii::$app->request->post())) {
            $uploadedfile = UploadedFile::getInstance($model, 'profile_picture');
            if ($model->validate()) {
                if (isset($uploadedfile->size) && !empty($uploadedfile)) {
                    $uploadedfile->saveAs(Yii::getAlias('@uploads') . '/' . $uploadedfile->baseName . '.' . $uploadedfile->extension);
                    $model->profile_picture = $uploadedfile;
                } else {
                    $model->profile_picture = $oldprofilepic;
                }
                if ($model->save(false)) {
                    Yii::$app->getSession()->setFlash('success', 'Your profile has been saved successfully.');

                    return $this->redirect([
                        'profile',
                        'id' => $model->id
                    ]);
                } else {
                    Yii::$app->getSession()->setFlash('error', 'Something went wrong. Please try again !');
                }
            } else {
                Yii::$app->getSession()->setFlash('error', 'Something went wrong. Please try again !');
            }
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     *
     */
    public function actionReferals()
    {
        try {
            $this->layout = 'inner-layout';
            Yii::setAlias("@imagesUrl", "@web/uploads");
            $model = new SendReferalCodeForm();
            $user_id = Yii::$app->user->getId();
            $userParentModel = new User();
            $totalCredits = $userParentModel->getTotalCredits();
            $allocatedCredits = User::find()->where(['parent_id' => $user_id])->sum('allocated_credits'); // parent has allocated to  team members
            $selfUsedCredits = UserRecords::find()->where(['user_id' => $user_id])->sum('credit_used'); // parent self used credits
            $parentCreditsUsedbyTeamMembers = User::find()   // parent credits used by its referrals
            ->innerJoin('tbl_user_records', 'tbl_user.id = tbl_user_records.user_id')
            ->andWhere(['tbl_user.parent_id' => $user_id])
            ->andWhere(['tbl_user_records.credit_type' => User::CREDITS_BUSINESS])
            ->sum('credit_used');
         
            $creditsRemaining =  $totalCredits - ($allocatedCredits + $selfUsedCredits + $parentCreditsUsedbyTeamMembers);
          

            if (isset($_POST['hasEditable'])) {
                $editableIndex = $_POST['editableIndex'];
                // use Yii's response format to encode output as JSON
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $referal_user_id = Yii::$app->request->post('editableKey');
                $allocated_credits = $_POST['User'][$editableIndex]['allocated_credits'];

                if ($creditsRemaining > $allocated_credits) {
                    if ($allocated_credits > 0) {
                        $userModel = User::findOne($referal_user_id);
                        $userModel->allocated_credits = $allocated_credits;
                        $userModel->credit_type = User::CREDITS_ALLOCATED;
                        $userModel->account_type = User::CREDITS_ALLOCATED;
                        if ($userModel->save()) {
                            return ['output' => '', 'message' => ''];
                        } else {
                            return ['output' => $userModel->errors, 'message' => 'Error Occoured'];
                        }
                    }
                } else {
                    return ['output' => '', 'message' => 'Not Enough Credits to Assign'];
                }
            }

            $dataProvider = new ActiveDataProvider([
                'query' => User::find()->where([
                    'parent_id' => $user_id,
                    'is_confirmed' => User::EMAIL_CONFIRM,
                    'is_admin_approve' => User::ADMIN_APPROVE
                ])
                    ->orderBy([
                        'id' => SORT_DESC
                    ]),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        return $this->render("referals", array(
            'dataProvider' => $dataProvider,
            'model' => $model
        ));
    }

    /**
     * Action to Send Invitation Users
     */

    public function actionSendInvitationLink()
    {
        try {
            $this->layout = 'inner-layout';
            $model = new SendReferalCodeForm();
            $user_id = Yii::$app->user->getId();
            $dataProvider = new ActiveDataProvider([
                'query' => User::find()->where([
                    'parent_id' => $user_id
                ])
                    ->orderBy([
                        'id' => SORT_DESC
                    ]),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
            if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->checkEmail()) {
                if ($model->sendInvitationLink()) {
                    Yii::$app->session->setFlash('success', 'Invitation Sent Successfully');
                    
                    // return $this->render('referals', [
                    //     'model' => $model,
                    //     'dataProvider' => $dataProvider
                    // ]);
                    return $this->refresh();
                } else {
                    Yii::$app->session->setFlash('error', 'Sorry, we are unable to send invitation for email provided.');
                }
            } else {
                Yii::$app->session->setFlash('error', $model->errors);
            }
            return $this->render('referals', [
                'model' => $model,
                'dataProvider' => $dataProvider
            ]);
        } catch (\Exception $ex) {
            Yii::$app->session->setFlash('error', $ex->getMessage());
        }
    }


    public function actionApprove($id)
    {
        Yii::setAlias("@imagesUrl", "@web/uploads");
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            // get model by ID
          
            $user = User::findOne($id);
            $usermodel = new UserApproveForm();
            if ($user) { // if found...
                    $is_admin_approve = ($_POST['is_admin_approve'] == 'true') ?  User::ADMIN_APPROVE : User::ADMIN_UNAPPROVE;
            }  

                $data= \Yii::$app->db->createCommand()
                ->update('tbl_user', ['is_admin_approve' => $is_admin_approve], ['id' => $id])
                ->execute();
                
                if($_POST['is_admin_approve'] == 'true'){

                    $user->sendUserApproveEmail($id);
                }
                else{
                    $user->sendUserRejectEmail($id);
                }

            
                if ($data) { // save
                    $message= ($_POST['is_admin_approve'] == 'true') ? 'Approved Successfully' : 'Rejected Successfully';
                    return [
                        'data' => [
                            'success' => true,
                            'is_admin_approve' => $_POST['is_admin_approve'], 
                            'message' =>  $message
                        ]
                    ];
                } // OK status
                else {
                    return [
                        'data' => [
                            'error' => true,
                            'message' =>  $data,
                        ]
                    ];
                } // errors
            }
        }



        public function actionDownload($id) 
        { 
              $download = UserRecords::find()->where([
                'id' => $id,
                'process_type' => 'file'
                ])->one();
            if($download){
            $path=\Yii::getAlias('@uploads').'/'.$download->process_value;
            if (file_exists($path)) {
                return Yii::$app->response->sendFile($path);
            } else {
                throw new NotFoundHttpException("can't find {$download->process_value} file");
            }
        }
        else{
            throw new NotFoundHttpException("File doesnot exist ");
        }

    }

    }

