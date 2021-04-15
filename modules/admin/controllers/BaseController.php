<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use app\models\User;
class BaseController extends Controller {
	public $layout = 'admin';

	public function beforeAction($action)
	{
		if(!\Yii::$app->user->isGuest && \Yii::$app->user->identity->role !== User::ROLE_ADMIN){
			throw new ForbiddenHttpException("You are not authorized");
		}
		return parent::beforeAction($action);
	}

}
