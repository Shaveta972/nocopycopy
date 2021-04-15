<?php

namespace app\models;

use Yii;
use app\models\User;

class UserApproveForm extends \app\models\BaseActiveRecord
{
    public $is_admin_approve;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['is_admin_approve','safe'],
        ];
    }

    public function sendUserApproveEmail($user_id)
    {
        /* @var $user User */
      //  $user_id = Yii::$app->user->getId();
       $user = User::findOne([
           'id' => $user_id
       ]);
 
        if (!$user) {
            return false;
        }
  
       $response=  Yii::$app->mailer
            ->compose(
                ['html' => 'sendUserApproveEmail-html'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => 'Nocopycopy'])
            ->setTo($this->email)
            ->setSubject('Account Approval')
            ->send();
    print_R($response);
        die();
    }

    public function sendUserRejectEmail($user_id)
    {
        /* @var $user User */
      //  $user_id = Yii::$app->user->getId();
       $user = User::findOne([
           'id' => $user_id
       ]);
 
        if (!$user) {
            return false;
        }
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'sendUserRejectEmail-html'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => 'Nocopycopy'])
            ->setTo($this->email)
            ->setSubject('Account Reject Notification')
            ->send();
    }
}


