<?php
namespace app\modules\admin\controllers;

use Yii;
use app\models\User;
use app\models\search\UserSearch;
use app\modules\admin\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\AdminLoginForm;
use app\models\AdminSignupForm;
use app\models\UserSignupForm;
use app\models\UserCategories;
use app\models\CreditUserSettings;
use app\models\Enquiries;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseController
{

    /**
     *
     * {@inheritdoc}
     *
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => [
                    'create',
                    'update',
                    'view',
                    'delete',
                    'index',
                    'logout',
                    'toggle-update'
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [
                            '@'
                        ]
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => [
                        'POST'
                    ]
                ]
            ]
        ];
    }

    public function actions()
    {
        return [
            'toggle-update' => [
                'class' => '\dixonstarter\togglecolumn\actions\ToggleAction',
                'modelClass' => User::className(),
                'attribute' => 'state_id'
            ]
        ];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = 'login';
        if (! Yii::$app->user->isGuest) {
            return $this->redirect(['/admin/dashboard/']);
        }

        $model = new AdminLoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack([
                '/admin/dashboard/'
            ]);
        }
        else{
            \Yii::$app->session->setFlash('Error', \Yii::t('app', $model->errors));
        }
        return $this->render('login', [
            'model' => $model
        ]);
    }

    public function actionAddAdmin()
    {
        $this->layout = 'login';

        $admin = User::findOne([
            'role' => User::ROLE_ADMIN
        ]);

        if ($admin !== null) {
            return $this->redirect([
                'site/login'
            ]);
        }

        $model = new AdminSignupForm();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $userModel = new User();
            $transaction = Yii::$app->db->beginTransaction();
            $userModel->attributes = $model->attributes;
            $userModel->role = User::ROLE_ADMIN;
            $userModel->state_id = User::STATE_ACTIVE;
            try {
                if ($userModel->save()) {
                    $transaction->commit();  
                    \Yii::$app->session->setFlash('adminCreated', \Yii::t('app', 'Please Login Here!.'));
                    return $this->redirect([
                    '/'
                ]);
                } else {
                    $transaction->rollBack();
                    \Yii::$app->session->setFlash('error', \Yii::t('app', 'Please try again!.'));
                }
            }
        catch(Exception $e){
            $transaction->rollBack();
        }
        }

        return $this->render('adminSignup', [
            'model' => $model
        ]);
    }
    public function actionIndexAjax($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [
            'results' => [
                'id' => '',
                'text' => ''
            ]
        ];
        if (! is_null($q)) {
            $query = new Query();
            $query->select('id, username AS text')
                ->from('tbl_user')
                ->where([
                'like',
                'username',
                $q
            ])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = [
                'id' => $id,
                'text' => User::find($id)->username
            ];
        }
        return $out;
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Lists all User models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
      
        $query = User::find()->with('referrals')->where(['role' => User::ROLE_USER])->andWhere(['parent_id' => 0]);//->all();
        $dataProvider= new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
        ]);
        print_r(Yii::$app->request->queryParams);
        //die();
        if(Yii::$app->request->queryParams){
            $dataProvider = $searchModel->search([Yii::$app->request->queryParams]);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

        /**
     * Lists all User Child models.
     *
     * @return mixed
     */
    public function actionMembers($id)
    {
        $searchModel = new UserSearch();
        $query = User::find($id)->where(['role' => User::ROLE_USER])->andWhere(['parent_id' => $id]);//->all();
        $dataProvider= new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
		]);
        return $this->render('members', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEnquiries(){
        $dataProvider = new ActiveDataProvider([
            'query' => Enquiries::find()
                ->orderBy([
                    'id' => SORT_DESC
                ]),
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);
        return $this->render('enquiries', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */

        // User Register
    public function actionCreate()
    {
        // print_R("ddjsndjs");
        // die();
        $model = new UserSignupForm();
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
                } else {
                    $title =  $model->title[0];
                }
                $new_password= $model->password;
                $userModel->setPassword();
                $userModel->getAuthKey();
                $userModel->attributes = $model->attributes;
                $userModel->username = $userModel->email;
                $userModel->user_category_id = $model->user_category_id;
                $userModel->title = $title;
                $userModel->role = User::ROLE_USER;
                $userModel->personal_credits = $credits;
                $userModel->contact_number = $model->contact_number;
                $userModel->state_id = User::STATE_ACTIVE;
                $userModel->is_confirmed = 1;
                try {
                    if ($userModel->save()) {
                        if ($model->sendNewUserCredentialsByAdmin($new_password)) {
                            Yii::$app->session->setFlash('success', 'New profile created successfully.');
                            return $this->redirect(['index']);
                        } else {
    
                            Yii::$app->session->setFlash('error', 'Sorry, we are unable to proceed for email provided.');
                            return $this->redirect('index', ['model' => $model]);
                        }
                    } else {
                        return $this->redirect('index', ['model' => $model]);
                        \Yii::$app->session->setFlash('error', $userModel->firstErrors);
                    }
                } catch (\Exception $e) {
                //    print_r($e);
                //     echo "</pre>";
                //       echo "<pre>";
                 
                    //return $this->redirect('index', ['model' => $model]);
                  //  throw new BadRequestHttpException($e->getMessage());
                }
            } else {
                // echo "<pre>";
                // print_r($model->errors);
                // echo "</pre>";
                Yii::$app->session->setFlash('error', $model->errors);
            }
            return $this->render('create', [
                'model' => $model,
                'listData' => $listData,
                // 'referal_code' => $code
            ]);
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
        $model = $this->findModel($id);

        $user_catgeories_model = new UserCategories();
        $user_categories =  $user_catgeories_model->findAllUserCategories();
        $listData = ArrayHelper::map($user_categories, 'id', 'category_name');
        try {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', "Profile Updated Successfully.");
                return $this->redirect(['index']);
            }

            return $this->render('update', [
            'model' => $model,
            'listData' => $listData,
            // 'title' => 'Update User'
        ]);
        }catch( \Exception $e){
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->safeDelete();

        return $this->redirect([
            'index'
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
}
