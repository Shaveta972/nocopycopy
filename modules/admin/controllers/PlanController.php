<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Plans;
use app\models\PlanSearch;
use app\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UserCategories;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

/**
 * PlanController implements the CRUD actions for Plans model.
 */
class PlanController extends BaseController
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

    /**
     * Before Action
     */
    public function beforeAction($action)
    {
       $this->layout = 'admin'; //your layout name
       return parent::beforeAction($action);
    }

    /**
     * Lists all Plans models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlanSearch();
      // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $query = Plans::find();
      $dataProvider= new ActiveDataProvider([
          'query' => $query,
          'pagination' => [
              'pageSize' => 10,
          ],
      ]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Plans model.
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
     * Creates a new Plans model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Plans();
        $user_catgeories_model = new UserCategories();
        $user_categories =  $user_catgeories_model->findAllUserCategories();
        $listData = ArrayHelper::map($user_categories, 'id', 'category_name');
      
        try {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                
                
                return $this->redirect(['index']);
            }

            return $this->render('create', [
            'model' => $model,
            'listData' => $listData
        ]);
        }catch(\Exception $e){
            echo "<pre>";
             print_r($e);
              print_r($model->errors);
               echo "</pre>";
        die();
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    /**
     * Updates an existing Plans model.
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
        try {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            }

            return $this->render('update', [
            'model' => $model,
            'listData' => $listData
        ]);
        }catch( \Exception $e){
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    /**
     * Deletes an existing Plans model.
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
     * Finds the Plans model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Plans the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Plans::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
