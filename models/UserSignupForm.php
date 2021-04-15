<?php

namespace app\models;

use Yii;
use yii\base\Model;
use kartik\password\StrengthValidator;
/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *          
 */
class UserSignupForm extends Model {
	public $email;
	public $first_name;
	public $last_name;
    public $password;
    public $role;
    public $referal_code;
    public $confirmPassword;
    public $contact_number;
    public $user_category_id;
    public $title;
    public $id;
    public $state_id;
    //public $acordul_tc1;
    public $school_name;
    public $business_name;
    public $is_subadmin;
	/**
	 *
	 * @return array the validation rules.
	 */

    public function rules()
    {
        return [
            [['email', 'password', 'first_name', 'last_name','confirmPassword'], 'required', 'message' => '{attribute} is required'],
            [['user_category_id'], 'required', 'message' => 'Please select role'],
            ['first_name', 'trim'],
            ['first_name', 'string', 'max' => 20],
            ['last_name', 'trim'],
            ['last_name', 'string', 'max' => 20],
            [['email'], 'email'],
            [['email'], 'string', 'max' => 50],
            ['is_subadmin','string'],
          //  ['acordul_tc1', 'requiredValue' => 1, 'message' => 'Please accept terms and conditions' , 'on' => 'register'],
         //   ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            [['password'], StrengthValidator::className(), 'preset'=>StrengthValidator::NORMAL, 'userAttribute' => 'email' ],
            [['confirmPassword'], StrengthValidator::className(), 'preset'=>StrengthValidator::NORMAL, 'userAttribute' => 'email' ],
            [['title','role','referal_code','school_name','business_name'],'safe'],
            [ 'confirmPassword','compare','compareAttribute' => 'password' ,'message'=>\Yii::t('app','Passwords don\'t match')]
        ];
    }

    public function sendActivationEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'state_id' => User::STATE_ACTIVE,
            'email' => $this->email,
        ]);
 
        if (!$user) {
            return false;
        }
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailConfirmationToken-html'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => 'Nocopycopy'])
            ->setTo($this->email)
            ->setSubject('Email Confirmation For NoCopyCopy')->send();
    }

    public function sendNewUserCredentialsByAdmin($newPassword)
    {
        /* @var $user User */
        $user = User::findOne([
            'state_id' => User::STATE_ACTIVE,
            'email' => $this->email,
        ]);
 
        if (!$user) {
            return false;
        }
        $user->password= $newPassword;
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'newUserCredentials-html'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => 'Nocopycopy'])
            ->setTo($this->email)
            ->setSubject('New User Credentials - Nocopycopy')->send();
    }
}
