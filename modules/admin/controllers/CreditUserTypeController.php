<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\CreditUserSettings;
use app\models\UserCategories;
use app\models\CreditUserSearch;
use app\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * CreditUserTypeController implements the CRUD actions for CreditUserSettings model.
 */
class CreditUserTypeController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
        	'access' => [
            'class' => \yii\filters\AccessControl::className(),
            'only' => ['create', 'update','view','delete','index'],
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
       $this->layout = 'admin'; //your layout name
       return parent::beforeAction($action);
    }

    /**
     * Lists all CreditUserSettings models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CreditUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CreditUserSettings model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CreditUserSettings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CreditUserSettings();

        $user_catgeories_model = new UserCategories();
        $user_categories =  $user_catgeories_model->findAllUserCategories();
        $listData = ArrayHelper::map($user_categories, 'id', 'category_name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'listData' => $listData
        ]);
    }

    /**
     * Updates an existing CreditUserSettings model.
     * If update is successful, the browser will be redirected to the 'view' page.
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'listData' => $listData
        ]);
    }

    /**
     * Deletes an existing CreditUserSettings model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->safeDelete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CreditUserSettings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CreditUserSettings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CreditUserSettings::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
