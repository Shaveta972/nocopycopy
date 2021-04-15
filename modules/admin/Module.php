<?php

namespace app\modules\admin;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\controllers';
    public $defaultRoute = 'dashboard/index';
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        \Yii::$app->setComponents([
            'user' => [
                'class'=>'yii\web\User',
                'identityClass' => 'app\models\User',
                'enableAutoLogin' => true,
                'loginUrl' => [
                    '/admin/user/login'
                ]
            ]
        ]);
        // custom initialization code goes here
    }
}
