<?php

namespace app\controllers;

use app\models\Auth;
use app\models\User;
use app\models\UserSignupForm;
use app\models\ResetPasswordForm;
use app\models\ConfirmEmailForm;
use app\models\UserCategories;
use app\models\CreditUserSettings;
use app\models\PasswordResetRequestForm;
use Yii;
use yii\helpers\ArrayHelper;
use app\models\LoginForm;
use app\models\Plans;
use app\models\UserPlans;
use yii\base\InvalidParamException;
use app\models\Testimonials;
use app\models\RoleSelectForm;
use app\models\CancelPlanForm;
use app\models\Enquiries;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\Exception;
class SiteController extends BaseController
{
    public $results;

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],

            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ]
        ];
    }


    public function actionFront()
    {
        $this->layout = 'landing-page-layout';
        Yii::setAlias("@imagesUrl", "@web/uploads");
        /** Admin case after login */
        $testimonialModel= Testimonials::find()->all();
        $plans = Plans::find()->where(['user_category_id' => 1 ])
        ->joinWith('categories')->all();
        if (isset(\Yii::$app->user->identity->role) && (\Yii::$app->user->identity->role == 0)) {
            return $this->render('front', ['testimonials'=> $testimonialModel, 'plans' => $plans]);
        }
        $session = Yii::$app->session;
        // && ($user->is_admin_approve==User::ADMIN_APPROVE)
        if (!Yii::$app->user->isGuest) {
            $user = \Yii::$app->user->identity;
            if ($user->user_category_id == 0 
                && $user->parent_id == 0 
                && !$session->has('referal_code') 
                 ) 
                {
                  return $this->redirect(['data']);
                } 
        }
     
        return $this->render('front', ['testimonials'=> $testimonialModel,'plans' => $plans]);
    }

    public function actionPlans()
    {
        Yii::setAlias("@imagesUrl", "@web/uploads");
        $this->layout = 'landing-page-layout';
        $model= new CancelPlanForm();
        $planExistID =0;
        $hidden= 1;
        $userPlanRecordID=0;
        $plans = Plans::find()->joinWith('categories')->all();

    if (!Yii::$app->user->isGuest) {
        $userplans= UserPlans::find()->where(['user_id' => Yii::$app->user->identity->id])
            ->andWhere(['isExpire' => 0])
            ->andWhere(['is_cancel' => 0])->andWhere(['status' => 1])->one();
        if ($userplans) {
            $planExistID= $userplans->plan_id;
            $userPlanRecordID= $userplans->id;
            $hidden= 0;
        } 
    }
        return $this->render('plans', ['plans' => $plans , 'planExistID' => $planExistID , 'hidden' => $hidden , 'userPlanRecordID' => $userPlanRecordID, 'model' => $model]);
    }

    public function actionFeatures()
    { 
         Yii::setAlias("@imagesUrl", "@web/uploads");
         $this->layout = 'landing-page-layout';
        return $this->render('features');
    }

    public function actionContact()
    {
        try {
            Yii::setAlias("@imagesUrl", "@web/uploads");
             $this->layout = 'landing-page-layout';
            $model = new Enquiries();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($model->save()) {
                    if ($model->sendAutoReplyEmail($model)) {
                        Yii::$app->session->setFlash('success', 'Your request has been submitted successfully. We will be get back to you soon');
                        return $this->redirect(['/site/front']);
                    } else {
                    }
                }
            }
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        return $this->render('contact', ['model' => $model]);
    }

    public function actionTerms()
    {   
        Yii::setAlias("@imagesUrl", "@web/uploads");
        $this->layout = 'landing-page-layout';
        return $this->render('terms');
    }
    /** 
     * 
     * Get Additional Information of User after Login with referal or fb'google
     */
    // public function actionAdditional()
    // {
    //     try{
    //     $this->layout = 'data-layout';
    //     $userId = \Yii::$app->user->identity->id;
    //     $model = new RoleSelectForm(['scenario' => 'additional']);

    //     if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
    //         $usermodel = User::findOne($userId);
    //         $usermodel->personal_credits = 500;
           
    //         $usermodel->is_subadmin = $model->is_subadmin;
    //         if ($usermodel->save()) {
    //             Yii::$app->session->setFlash('success', 'Information Saved Successfully. Please continue to your account');
    //             return $this->redirect(['site/front']);
    //         } else {
    //             Yii::$app->session->setFlash('error', 'Something Went Wrong');
    //         }
    //     } else {
    //          Yii::$app->session->setFlash('error', $model->errors);
    //     }
    //     return $this->render('additonal', [
    //         'model' => $model,
    //     ]);
    // }
    //     catch(\Exception $e){
    //          throw new BadRequestHttpException($e->getMessage());
    //     }
    // }

    public function actionData()
    {
        try{
            Yii::setAlias("@imagesUrl", "@web/uploads");
        if (!Yii::$app->user->isGuest) {
            $user = \Yii::$app->user->identity;
            if ($user->user_category_id != 0) {
                return $this->redirect('front');
            }
        }

        $this->layout = 'data-layout';
        $userId = \Yii::$app->user->identity->id;
        $model = new RoleSelectForm();

        /**
         * This model is used to get the User Categories and show in Register Page
         */
        $user_categories_model = new UserCategories();
        $user_categories =  $user_categories_model->findAllUserCategories();
        $listData = ArrayHelper::map($user_categories, 'id', 'category_name');

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $usermodel = User::findOne($userId);

            $getCategoryData = UserCategories::find()->select('category_type')->where(['id' => $model->user_category_id])->one();
            $category_type = $getCategoryData->category_type;

            $user_credits_model = new CreditUserSettings();
            $credits =  $user_credits_model->findCreditsByID($model->user_category_id);

            if (!empty($credits->credit_value)) {
                $credits = $credits->credit_value;
            }
         
            $user_title = $user_categories_model->findCategoryNameByID($model->user_category_id);
            $title = empty($model->title) ? $user_title->category_name : $model->title;
            $usermodel->user_category_id = $model->user_category_id[0];
            $usermodel->personal_credits = $credits;
            $usermodel->title = $title;
            $usermodel->school_name = isset($model->school_name)?$model->school_name : '';
            $usermodel->business_name =isset( $model->business_name )?$model->business_name : '';
            if ($model->user_category_id > 0 && !empty($category_type) && $category_type !== 'Individual') {
                $referal_code = Yii::$app->security->generateRandomString(8);
                $usermodel->referal_code = $referal_code;
            }
            if ($usermodel->save()) {
                Yii::$app->session->setFlash('success', 'Role Saved Successfully. Please continue to your account');
                
             if($user->is_admin_approve != User::ADMIN_APPROVE){
                 Yii::$app->user->logout();
                Yii::$app->getSession()->setFlash('warning', Yii::t('app', "Thanks for registering with us. Your profile is under review. Once approved, we will notify you through email, thanks for your patience"));
               
              return $this->redirect(['/']);
                    // Yii::$app->getSession()->setFlash('warning', Yii::t('app', "Your profile is under review. Once approved, we will notify you through email, thanks for your patience"));
             
                    //  return $this->redirect(['/']);
             }
                return $this->redirect(['site/front']);
            } else {
                Yii::$app->session->setFlash('error', 'Something Went Wrong');
            }
        } else {
            Yii::$app->session->setFlash('error', $model->errors);
        }
        return $this->render('data', [
            'model' => $model,
            'listData' => $listData,
            'user_categories' =>$user_categories

        ]);
    }catch(\Exception $e){

         throw new BadRequestHttpException($e->getMessage());
        

    }
    }

    // User Register
    public function actionRegister($token = null)
    {
        $this->layout = 'landing-page-layout';

//$this->layout = 'inner-layout';
        $model = new UserSignupForm();
        $code = $token;
        /**
         * Check for the user via inviatation link
         */
        if (!empty($token) && isset($token)) {
            if (!User::isReferalCodeValid($token)) {
                Yii::$app->session->setFlash('error', 'This is not valid invitation link');
                return $this->goHome();
            } else {
                $session = Yii::$app->session;
                $session->set('referal_code', $token);
               
            }
        }

        /**
         * This model is used to get the User Categories and show in Register Page
         */
        $user_catgeories_model = new UserCategories();
        $user_categories =  $user_catgeories_model->findAllUserCategories();
        $listData = ArrayHelper::map($user_categories, 'id', 'category_name');

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $userModel = new User();
            
            /**
             *  This model is used to get the credits according to user category type(Table Name :: user_categories)
             */

            if ($model->user_category_id > 0) {
                $getCategoryData = UserCategories::find()->select('category_type')->where(['id' => $model->user_category_id])->one();
                $category_type = $getCategoryData->category_type;
                $credit_type= User::CREDITS_PERSONAL;
                $account_type= User::CREDITS_PERSONAL;
            }
            
            /**
             *  This model is used to get the credits according to user category (Table Name :: credit_user_settings)
             */

            $user_credits_model = new CreditUserSettings();
            if ($model->user_category_id > 0) {
                $credits =  $user_credits_model->findCreditsByID($model->user_category_id);
                $credits = $credits->credit_value;
            } else {
                $credits = 500;
            }

            if ($model->user_category_id > 0 && !empty($category_type)) {
                $user_title = $user_catgeories_model->findCategoryNameByID($model->user_category_id);
                $title = $user_title->category_name;
            } 
            if ($code != null) {
                $userdata = $userModel->getParentIDByReferalCode($code);
                $parent_id = ($userdata != NULL) ? $userdata->id : 0;
                $credit_type= User::CREDITS_PERSONAL;
                $account_type= User::CREDITS_PERSONAL;
                $title = User::getSubAdminState($model->is_subadmin);
            } else {
                $parent_id = 0;
            }
            
            // echo "<pre>";
            // print_r($model);
            // echo "</pre>";
            //  echo $category_type;
            //  die();
            $userModel->setPassword();
            $userModel->getAuthKey();
            $userModel->setEmailConfirmCode();
            $userModel->attributes = $model->attributes;
            $userModel->username = $userModel->email;
            $userModel->parent_id = $parent_id;
            $userModel->user_category_id = $model->user_category_id;
            $userModel->title = $title;
            $userModel->school_name = isset($model->school_name)?$model->school_name : '';
            $userModel->business_name =isset( $model->business_name )?$model->business_name : '';
            $userModel->role = User::ROLE_USER;
            $userModel->personal_credits = $credits;
//$userModel->contact_number = $model->contact_number;
            $userModel->account_type = $account_type;
            $userModel->credit_type = $credit_type;
            
            if ($model->user_category_id > 0 && $category_type == 'Individual') {
                    $userModel->is_admin_approve = User::ADMIN_APPROVE;
             }
            if ($parent_id == 0 && $category_type !== 'Individual' && empty($token)) {
                $referal_code = Yii::$app->security->generateRandomString(8);
                $userModel->referal_code = $referal_code;
            }
    
            $userModel->state_id = User::STATE_ACTIVE;
            // print_R($userModel);
            // die();
            try {
                if ($userModel->save()) {
                    if ($model->sendActivationEmail()) {
                        Yii::$app->session->setFlash('success', 'Check your email for further instructions');
                        return $this->goHome();
                    } else {

                        Yii::$app->session->setFlash('error', 'Sorry, we are unable to proceed for email provided.');
                    }
                } else {
                    \Yii::$app->session->setFlash('error', $userModel->firstErrors);
                }
            } catch (\Exception $e) {
                throw new BadRequestHttpException($e->getMessage());
            }
        } else {
            \Yii::$app->session->setFlash('error', $model->firstErrors);
        }
        return $this->render('register', [
            'model' => $model,
            'listData' => $listData,
            'referal_code' => $code
        ]);
    }

    public function actionCategories(){
    \Yii::$app->response->format = 'json';
       $id= $_POST['id'];
            $getCategoryData = UserCategories::find()->select('category_type')->where(['id' => $id])->one();
            $category_type = $getCategoryData->category_type;
            return [
                    'success' => true,
                    'category_type' =>  $category_type
                ];
        
    }


    public function actionConfirmEmail($token)
    {
        $this->layout = 'landing-page-layout';

     //   $this->layout = 'inner-layout';
        try {
            $model = new ConfirmEmailForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->confirmEmail()) {
            Yii::$app->session->setFlash('success', 'Congratulations, your email is confirmed successfully.');
            return $this->render('confirmEmailAccount');
        } else {
            Yii::$app->session->setFlash('success', 'Something went wrong.Try again');
        }

        return $this->goHome();
    }

    // User Login

    public function actionLogin()
    {
        $this->layout = 'landing-page-layout';

      //  $this->layout = 'inner-layout';
        if (!Yii::$app->user->isGuest) {
            return $this->redirect([
                '/site/front/'
            ]);
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->login()) {
                if (\Yii::$app->user->identity->role == 1) {
                    $name= Yii::$app->user->identity->first_name;
                    if (!empty(Yii::$app->user->identity->business_name)) {
                        $data= ", ". Yii::$app->user->identity->business_name;
                    } elseif (!empty(Yii::$app->user->identity->school_name)) {
                        $data= ", ". Yii::$app->user->identity->school_name;
                    } else {
                        $data = '';
                    }
                    \Yii::$app->session->setFlash('success', \Yii::t('app', 'Welcome '.$name."".$data));
                    return $this->goBack([
                        '/site/front/'
                    ]);
                } else {
                    return $this->redirect(['admin/user/login']);
                }
            }
        }
        return $this->render('login', [
            'model' => $model
        ]);
    }

    public function onAuthSuccess($client)
    {
        if ($client) {
            $session = Yii::$app->session;

            $attributes = $client->getUserAttributes();
            $email = ArrayHelper::getValue($attributes, 'email');
            $id =    ArrayHelper::getValue($attributes, 'id');
            $first_name = empty(ArrayHelper::getValue($attributes, 'first_name')) ? ArrayHelper::getValue($attributes, 'given_name') : 'Login';
            $last_name =  empty(ArrayHelper::getValue($attributes, 'last_name')) ? ArrayHelper::getValue($attributes, 'family_name') : 'User';

            /** @var Auth $auth */
            $auth = Auth::find()->where([
                'source' => $client->getId(),
                'source_id' => $id,
            ])->one();

            if (empty($email)) {
                Yii::$app->getSession()->setFlash('error', Yii::t('app', "Unable to log in. Email is not provided"));
                return false;
            }
            if ($auth) { // login
                /** @var User $user */
                $user = $auth->user;
                if (!$user || $user->is_admin_approve == User::ADMIN_PENDING) {
                    Yii::$app->getSession()->setFlash('warning', Yii::t('app', "Your profile is under review. Once approved, we will notify you through email, thanks for your patience"));
                    return false;
                }
                if (!$user || $user->is_admin_approve == User::ADMIN_UNAPPROVE) {
                    Yii::$app->getSession()->setFlash('warning', Yii::t('app', "Your profile is disapproved by adninistrator.Please contact to the administrator."));
                    return false;
                }
                if ($this->updateUserInfo($user)) {
                    Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
                } else {
                    Yii::$app->getSession()->setFlash('error', Yii::t('app', "Unable to log in. It is blocked by admin"));
                }
            } else { // signup
                $existingUser = User::findOne(['email' => $email]);
                if ($existingUser) {
                    $auth = new Auth([
                        'user_id' => $existingUser->id,
                        'source' => $client->getId(),
                        'source_id' => (string)$id,
                    ]);
                    
                    if (!$existingUser || $existingUser->is_admin_approve == User::ADMIN_PENDING) {
                        Yii::$app->getSession()->setFlash('warning', Yii::t('app', "Your profile is under review. Once approved, we will notify you through email, thanks for your patience"));
                        return false;
                    }
                    if (!$existingUser || $existingUser->is_admin_approve == User::ADMIN_UNAPPROVE) {
                        Yii::$app->getSession()->setFlash('warning', Yii::t('app', "Your profile is disapproved by adninistrator.Please contact to the administrator."));
                        return false;
                    }
                    if ($this->updateUserInfo($existingUser) && $auth->save()) {
                        Yii::$app->user->login($existingUser, Yii::$app->params['user.rememberMeDuration']);
                    } else {
                        Yii::$app->getSession()->setFlash(
                            'error',
                            Yii::t('app', 'Unable to save {client} account: {errors}', [
                                'client' => $client->getTitle(),
                                'errors' => json_encode($auth->getErrors()),
                            ])
                        );
                    }
                } else {
                    $password = Yii::$app->security->generateRandomString(12);
                    if ($session->has('referal_code')) {
                        $code = $session->get('referal_code');

                        if ($code != null) {
                            $userModel = new User();
                            $userdata = $userModel->getParentIDByReferalCode($code);
                            $parent_id = ($userdata != null) ? $userdata->id : 0;
                        }
                    }
                    $user = new User([
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email,
                        'username' => $email,
                        'password' => $password,
                        'role' => User::ROLE_USER,
                        'parent_id' => isset($parent_id) ? $parent_id : 0,
                        'is_confirmed' => User::EMAIL_CONFIRM,
                        'auth_key' => Yii::$app->security->generateRandomString()
                    ]);

                    $transaction = User::getDb()->beginTransaction();
                    if ($user->save()) {
                        $auth = new Auth([
                            'user_id' => $user->id,
                            'source' => $client->getId(),
                            'source_id' => (string)$id,
                        ]);
                        if ($auth->save()) {
                            $transaction->commit();
                           // Yii::$app->getSession()->setFlash('warning', Yii::t('app', "Your profile is under review. Once approved, we will notify you through email, thanks for your patience"));
                         Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
                        } else {
                            $transaction->rollBack();
                            Yii::$app->getSession()->setFlash('error', [
                                Yii::t('app', 'Unable to save {client} account: {errors}', [
                                    'client' => $client->getTitle(),
                                    'errors' => json_encode($auth->getErrors()),
                                ]),
                            ]);
                        }
                    } else {
                        $transaction->rollBack();
                        Yii::$app->getSession()->setFlash('error', [
                            Yii::t('app', 'Unable to save user: {errors}', [
                                'client' => $client->getTitle(),
                                'errors' => json_encode($user->getErrors()),
                            ]),
                        ]);
                    }
                }
            }
        }
        //    return $this->render('front');
    }

    /**
     * @param User $user
     */
    private function updateUserInfo(User $user)
    {
      
        if ($user->state_id === User::STATE_ACTIVE ) {
            $password = Yii::$app->security->generateRandomString(12);
            $user->password = $password;
            return $user->save();
        }
       return $user->state_id !== User::STATE_INACTIVE;
    }

    public function actionLogout()
    {
        $session = Yii::$app->session;
        Yii::$app->user->logout();
        unset($session['referal_code']);
        Yii::$app->session->setFlash('success', 'You have been successfully logged out!');
        return $this->redirect(['/']);
    }
    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $this->layout = 'landing-page-layout';

//$this->layout = 'inner-layout';
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
        $this->layout = 'landing-page-layout';

         //   $this->layout = 'inner-layout';
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');
            return $this->redirect(['/site/login']);
        }

        return $this->render('resetPassword', ['model' => $model]);
    }
    
        /**
     * Resend confirmation code
     *
     * @return mixed
     */
    public function actionResendConfirmationCode($token)
    {
        echo $token;
        // $this->layout = 'inner-layout';
        // $model = new PasswordResetRequestForm();

        // if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        //     if ($model->sendEmail()) {
        //         Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
        //         return $this->goHome();
        //     } else {
        //         Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
        //     }
        // }

        // return $this->render('requestPasswordResetToken', [
        //     'model' => $model,
        // ]);
    }
}
