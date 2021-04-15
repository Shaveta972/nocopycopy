<?php

namespace app\modules\admin\controllers;

use app\modules\admin\controllers\BaseController;
use yii\filters\AccessControl;
use app\models\User;
use yii\data\ActiveDataProvider;

class DashboardController extends BaseController {
	public function behaviors() {
		return [ 
				'access' => [ 
						'class' => AccessControl::className (),
						'only' => [ 
								'index' 
						],
						'rules' => [ 
								// allow authenticated users
								[ 
										'allow' => true,
										'roles' => [ 
												'@' 
										] 
								] 
						] 
				] 
		];
	}
	public function actionIndex() {
		$query = User::find()->where('DATE(FROM_UNIXTIME(created_at)) >= CURDATE()')->andWhere(['role' => 1]);
		$dataProvider= new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
		]);
		return $this->render ( 'index' , ['dataProvider' => $dataProvider]  );
	}


}
