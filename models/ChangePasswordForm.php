<?php

namespace app\models;

use Yii;
use yii\base\Model;
use kartik\password\StrengthValidator;

/**
 *   is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *          
 */
class ChangePasswordForm extends Model {
    
    public $old_password;
	// public $new_password;
    // public $repeat_password;
    private $_user;
    public $id;
    public $new_password;
    public $confirm_password;
    public $email;

    public function __construct($id, $config = [])
    {
        $this->_user = User::findOne($id);
        
        if (!$this->_user) {
            throw new InvalidParamException('Unable to find user!');
        }
        
        $this->id = $this->_user->id;
        parent::__construct($config);
    }

	/**
	 *
	 * @return array the validation rules.
	 */

    public function rules()
	{
        return [
            [['old_password','new_password','confirm_password'], 'required'],
            [['old_password','new_password','confirm_password'], 'string', 'min' => 8],
            [['new_password'], StrengthValidator::className(), 'preset'=>StrengthValidator::NORMAL, 'userAttribute' => 'email'],
            ['old_password','findPasswords'],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password'],
        ];
    }
   
    public function attributeLabels(){
        return [
            'old_password'=>'Old Password',
            'new_password'=>'New Password',
            'repeat_password'=>'Repeat New Password',
        ];
    }
   //matching the old password with your existing password.
	public function findPasswords($attribute, $params)
	{
        $user = User::find()->where([
            'id'=>Yii::$app->user->identity->id
        ])->one();
    
        $validateOldPass = Yii::$app->security->validatePassword($this->old_password,$user->password);
        if(!$validateOldPass)
        {
            $this->addError($attribute, 'Old password is incorrect.');
        }
    }
     /**
     * Changes password.
     *
     * @return boolean if password was changed.
     */
    public function changePassword()
    {
        $user = $this->_user;
        $user->password=  Yii::$app->getSecurity()->generatePasswordHash($this->new_password);
        return $user->save(false);
    }

    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->old_password);
    }
}
