<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_user".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $auth_key
 * @property string $email
 * @property string $password
 * @property string $password_reset_token
 * @property string $profile_picture
 * @property int $credits
 * @property int $age
 * @property int $role
 * @property int $state_id
 * @property string $address
 * @property string $contact_number
 * @property int $deleted_at
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $isDeleted
 */
class SendReferalCodeForm extends \app\models\BaseActiveRecord
{
    public $email;

	const STATE_DRAFT = 0;
	const STATE_PUBLISHED = 1;
	public function getStateOptions(){
		return [
			self::STATE_DRAFT => 'Draft',
			self::STATE_PUBLISHED => 'Published',
		];
	}
	public function getState($id){
		$options = $this->getStateOptions();
		return $options[$id]?$options[$id]:"NA";
	}
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
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
        //    ['email', 'unique', 'message' => 'This email already exists.'],
            // ['email', 'exist',
            //     'targetClass' => '\app\models\User',
            //     'filter' => ['state_id' => User::STATE_ACTIVE],
            //     'message' => 'The account is inactive. Please contact to administrator.'
            // ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'email' => 'Email',
            'password' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'profile_picture' => 'Profile Picture',
            'personal_credits' => 'Credits',
            'age' => 'Age',
            'role' => 'Role',
            'state_id' => 'State',
            'address' => 'Address',
            'contact_number' => 'Contact Number',
            'isDeleted' => Yii::t('app', 'Is Deleted'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'created_at' => Yii::t('app', 'Created On'),
            'updated_at' => Yii::t('app', 'Updated On'),
            'created_by' => Yii::t('app', 'Created By')
        ];
    }

     /**
     * Sends an email with a link, for sending the referal code.
     *
     * @return bool whether the email was send
     */
    public function sendInvitationLink()
    {
        /* @var $user User */
        $user_id = Yii::$app->user->getId();
        $user = User::findOne([
            'id' => $user_id
        ]);
 
        if (!$user) {
            return false;
        }
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'referalInvitationCode-html'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => 'Nocopycopy'])
            ->setTo($this->email)
            ->setSubject('Referal Invitation for Nocopycopy')
            ->send();
    }

    public function checkEmail(){
        
      /* @var $user User */
       $parent_user_id = Yii::$app->user->getId();
    
    $checkUserIsReferral =  User::find()->where(['email' => $this->email , 'parent_id' => $parent_user_id])->one();
    if(!$checkUserIsReferral){
        return true;
    }
    $checkUserIsFreelancer = User::find()->where(['email' => $this->email , 'user_category_id' => '1'])->one();
     if($checkUserIsFreelancer){
        return true;
   }
  
    return false;

      
    }
 
}


