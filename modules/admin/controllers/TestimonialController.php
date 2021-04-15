<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Testimonials;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * TestimonialController implements the CRUD actions for Testimonials model.
 */
class TestimonialController extends Controller
{
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
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
    
    public function actions(){
        return [

        'toggle-update'=>[
            'class'=>'\dixonstarter\togglecolumn\actions\ToggleAction',
            'modelClass'=>Testimonials::className()
        ]
        ];
    }

    /**
     * Lists all Testimonials models.
     * @return mixed
     */
    public function actionIndex()
    {
       
        $dataProvider = new ActiveDataProvider([
            'query' => Testimonials::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Testimonials model.
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
     * Creates a new Testimonials model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Testimonials();
        // $model->scenario = 'create';
        if ($model->load(Yii::$app->request->post())) {
            $uploadedfile = UploadedFile::getInstance($model, 'testimonials_image');
            if ($model->validate()) {
                if (!is_null($uploadedfile)) {
                  //  $model->image_src_filename = $uploadedfile->name;
                  //  $ext = end((explode(".", $uploadedfile->name)));
                     // generate a unique file name to prevent duplicate filenames
                     //$model->testimonials_image = Yii::$app->security->generateRandomString().".{$ext}";
                     // the path to save file, you can set an uploadPath
                     // in Yii::$app->params (as used in example below)                       
                       // Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/status/';
                     //   $path = Yii::$app->params['uploadPath'] . $model->testimonials_image;
                        $uploadedfile->saveAs(Yii::getAlias('@uploads') . '/testimonials/' . $uploadedfile->baseName . '.' . $uploadedfile->extension);
                   }
                // if (isset($uploadedfile->size) && !empty($uploadedfile)) {
                //     $uploadedfile->saveAs(Yii::getAlias('@uploads') . '/testimonials/' . $uploadedfile->baseName . '.' . $uploadedfile->extension);
                //     $model->testimonials_image = $uploadedfile;
                // }
                if ($model->save(false)) {
             

                    return $this->redirect(['index']);
                } else {
                   // return $model->errors;
         
                }
            } else {
              //  return $model->errors;
            }
        }
        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->id]);
        // }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Testimonials model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';
        $oldtestimonialImage = $model->testimonials_image;
        if ($model->load(Yii::$app->request->post())) {
            $uploadedfile = UploadedFile::getInstance($model, 'testimonials_image');
            if ($model->validate()) {
                if (isset($uploadedfile->size) && !empty($uploadedfile)) {
                    $uploadedfile->saveAs(Yii::getAlias('@uploads') . '/testimonials/' . $uploadedfile->baseName . '.' . $uploadedfile->extension);
                    $model->testimonials_image = $uploadedfile;
                } else {
                    $model->testimonials_image = $oldtestimonialImage;
                }
                if ($model->save(false)) {
             

                    return $this->redirect(['index']);
                } else {
                    return $model->errors;
         
                }
            } else {
                return $model->errors;
            }
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }
    

    /**
     * Deletes an existing Testimonials model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Testimonials model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Testimonials the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Testimonials::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
