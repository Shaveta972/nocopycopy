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
class PasswordResetRequestForm extends \app\models\BaseActiveRecord
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
            ['email', 'exist',
                'targetClass' => '\app\models\User',
                'filter' => ['state_id' => User::STATE_ACTIVE],
                'message' => 'The account is inactive. Please contact to administrator.'
            ],
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
            'credits' => 'Credits',
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
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'state_id' => User::STATE_ACTIVE,
            'email' => $this->email,
        ]);
 
        if (!$user) {
            return false;
        }
 
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => 'Nocopycopy'])
            ->setTo($this->email)
            ->setSubject('Password reset for Nocopycopy')
            ->send();
    }
 
}


