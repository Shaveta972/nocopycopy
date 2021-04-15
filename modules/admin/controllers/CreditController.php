<?php

namespace app\modules\admin\controllers; 

use Yii; 
use app\models\CreditScanSettings; 
use app\models\CreditScanSearch; 
use app\controllers\BaseController; 
use yii\web\NotFoundHttpException; 
use yii\filters\VerbFilter; 

/** 
 * CreditController implements the CRUD actions for CreditScanSettings model. 
 */ 
class CreditController extends BaseController
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
     * Lists all CreditScanSettings models. 
     * @return mixed 
     */ 
    public function actionIndex() 
    { 
        $searchModel = new CreditScanSearch(); 
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams); 

        return $this->render('index', [ 
            'searchModel' => $searchModel, 
            'dataProvider' => $dataProvider, 
        ]); 
    } 

    /** 
     * Displays a single CreditScanSettings model. 
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
     * Creates a new CreditScanSettings model. 
     * If creation is successful, the browser will be redirected to the 'view' page. 
     * @return mixed 
     */ 
    public function actionCreate() 
    { 
        $model = new CreditScanSettings(); 

        if ($model->load(Yii::$app->request->post()) && $model->save()) { 
            return $this->redirect(['view', 'id' => $model->id]); 
        } 

        return $this->render('create', [ 
            'model' => $model, 
        ]); 
    } 

    /** 
     * Updates an existing CreditScanSettings model. 
     * If update is successful, the browser will be redirected to the 'view' page. 
     * @param integer $id
     * @return mixed 
     * @throws NotFoundHttpException if the model cannot be found 
     */ 
    public function actionUpdate($id) 
    { 
        $model = $this->findModel($id); 
        if ($model->load(Yii::$app->request->post()) && $model->save()) { 
            \Yii::$app->session->setFlash('success', \Yii::t('app', 'Updated Successfully'));
            return $this->redirect('index'); 
        } 
        return $this->render('update', [ 
            'model' => $model, 
        ]); 
    } 

    /** 
     * Deletes an existing CreditScanSettings model. 
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
     * Finds the CreditScanSettings model based on its primary key value. 
     * If the model is not found, a 404 HTTP exception will be thrown. 
     * @param integer $id
     * @return CreditScanSettings the loaded model 
     * @throws NotFoundHttpException if the model cannot be found 
     */ 
    protected function findModel($id) 
    { 
        if (($model = CreditScanSettings::findOne($id)) !== null) { 
            return $model; 
        } 

        throw new NotFoundHttpException('The requested page does not exist.'); 
    } 
} 