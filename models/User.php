<?php

namespace app\models;

use Yii;
use yii\helpers\Html;
use yii\base\NotSupportedException;
use app\models\UserPlans;


class User extends BaseActiveRecord implements \yii\web\IdentityInterface
{
    use \dixonstarter\togglecolumn\ToggleActionTrait;

    const ROLE_ADMIN = 0;
    const ROLE_USER = 1;
    const STATE_ACTIVE = 1;
    const STATE_INACTIVE = 0;
    const EMAIL_CONFIRM = 1;
    const EMAIL_INACTIVE=0;

    const ADMIN_PENDING = 0;
    const ADMIN_APPROVE = 1;
    const ADMIN_UNAPPROVE = 2;

    const CREDITS_PERSONAL = 1;
    const CREDITS_BUSINESS = 2;
    const CREDITS_ALLOCATED = 3;

    const CAN_SWITCH = 1;

    const TEACHER_SUBADMIN = '1';
    const STUDENT_SUBADMIN = '2';
    const STAFF_SUBADMIN = '3';



    public $credits_used;
    public $assigned_credits;
    public $plan_credits;
    public $total_credits;
    public $created_date;
    public $first_name;

    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public static function findIdentity($id)
    {
        $user = User::findOne($id);
        return $user;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'state_id' => self::STATE_ACTIVE]);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    public static function getRole($id)
    {
        $options = self::getRoleOptions();
        return isset($options[$id]) ? $options[$id] : 'NA';
    }

    public static function getRoleOptions()
    {
        return [
            self::ROLE_ADMIN => 'Admin',
            self::ROLE_USER => 'User'
        ];
    }

    public static function getApproveStatus($id)
    {
        $options = self::getApproveStatusOptions();
        return isset($options[$id]) ? $options[$id] : 'NA';
    }

    public static function getApproveStatusOptions()
    {
        return [
             self::ADMIN_PENDING  => 'Pending',
             self::ADMIN_APPROVE  => 'Approved',
             self::ADMIN_UNAPPROVE  => 'Rejected',

        ];
    }

    public static function getState($id)
    {
        $options = self::getStateOptions();
        return isset($options[$id]) ? $options[$id] : 'NA';
    }

    public static function getStateOptions()
    {
        return [
            self::STATE_INACTIVE => 'Inactive',
            self::STATE_ACTIVE => 'Active'
        ];
    }

    public static function getCreditAccountState($id)
    {
        $options = self::getCreditAccountStateOptions();
        return isset($options[$id]) ? $options[$id] : 'NA';
    }

    public static function getCreditAccountStateOptions()
    {
        return [
            self::CREDITS_ALLOCATED => 'Allocated',
            self::CREDITS_PERSONAL => 'Personal',
            self::CREDITS_BUSINESS => 'Admin',
        ];
    }

    public static function getSubAdminState($id)
    {
        $options = self::getSubAdminStateOptions();
        return isset($options[$id]) ? $options[$id] : 'NA';
    }

    public static function getSubAdminStateOptions()
    {
        return [
             self::TEACHER_SUBADMIN => 'Lecturer Admin',
             self::STUDENT_SUBADMIN => 'Student Admin',
             self::STAFF_SUBADMIN => 'Staff Admin',
        ];
    }
    public function getToggleItems()
    {
        // custom array for toggle update
        return [
            'on' => [
                'value' => 1,
                'label' => 'Active'
            ],
            'off' => [
                'value' => 0,
                'label' => 'Inactive'
            ]
        ];
    }

    public function rules()
    {
        return [
            [['email', 'password', 'first_name', 'last_name', 'username', 'role','country','address'], 'required'],
           // [['username', 'email'], 'unique'],
            ['business_credits','integer'],
            ['personal_credits','integer'],
            ['credit_type','integer'],
            ['street_address','string'],
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [['age'], 'string', 'message' => 'Please enter your birth date.'],
            [['country'], 'string', 'message' => 'Please select your country.'],
            [['state'], 'string', 'message' => 'Please select your state.'],
            [['city'], 'string', 'message' => 'Please select your city.'],
            [['zipcode'], 'string', 'message' => 'Please select your zipcode.'],
            [['address'], 'string', 'message' => 'Please enter  your address.'],
            [['first_name', 'last_name', 'contact_number'], 'string', 'max' => 100],
            [['profile_picture'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'on' => 'update'],
            [['account_type','business_name','school_name'], 'safe',  'on' => 'update'],
            [['state_id', 'role','is_confirmed','is_admin_approve'], 'integer'],
            ['referal_code','string'],
            ['is_subadmin','string'],
            ['created_by', 'exist', 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']]
        ];
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord || $this->isAttributeChanged('password'))
        {
            $this->setPassword();
        }
        return parent::beforeValidate();
    }

    public function setPassword()
    {

     $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
    }

    public function getFullName()
    {
        return Html::encode($this->first_name . ' ' . $this->last_name);
    }

    public function sumParentCredits($user_id){
        $allocatedCredits = User::find()->where(['parent_id' => $user_id])->sum('allocated_credits'); // parent has allocated to team
        $selfUsedCredits = UserRecords::find()->where(['user_id' => $user_id])->sum('credit_used'); // parent self used credits
        $creditstotal= $allocatedCredits + $selfUsedCredits;
        return $creditstotal;
    }

    public function getParentRemainingCredits($userId)
    {
        $totalCredits = $this->getPersonalCredits($userId);
        $usedCredits =  $this->sumParentCredits($userId);
        $creditsRemaining =  $totalCredits - $usedCredits;
        return ($creditsRemaining > 0 ) ? $creditsRemaining : 0 ;
    }


    public function getAllocatedRemainingCredits($userId){
            $allocated_credits_used = UserRecords::find()->where(['user_id' => $userId , 'credit_type' => User::CREDITS_ALLOCATED])->sum('credit_used');
            $remaining_credits =  Yii::$app->user->identity->allocated_credits - $allocated_credits_used;
            return $remaining_credits;
    }

    public function getPersonalRemainingCredits($userId){
            $pcredits_used = UserRecords::find()->where(['user_id' => $userId , 'credit_type' => User::CREDITS_PERSONAL])->sum('credit_used');
            $remaining_credits =  Yii::$app->user->identity->personal_credits - $pcredits_used;
         
         return $remaining_credits;
    }

    public function getPersonalCredits($userId){
        $planCredits = 0;
        $planModel =  UserPlans::find()->where(['user_id' => $userId])->with('plans')->andWhere(['isExpire' => 0])->andWhere(['is_cancel' => 0])->andWhere(['status' => 1])->one();
        if ($planModel) {
            $planCredits = $planModel->credits;
        }
        $personal_credits =  Yii::$app->user->identity->personal_credits + $planCredits;
        return $personal_credits;
}


    public function getRemainingCredits($userId)
    {   
        $parent_id= Yii::$app->user->identity->parent_id;

        if ($parent_id > 0 ){
            if (Yii::$app->user->identity->credit_type == User::CREDITS_ALLOCATED ) {
                $allocated_credits_used = UserRecords::find()->where(['user_id' => $userId , 'credit_type' => User::CREDITS_ALLOCATED])->sum('credit_used');
                $remaining_credits =  Yii::$app->user->identity->allocated_credits - $allocated_credits_used;
            }

            if (Yii::$app->user->identity->credit_type == User::CREDITS_BUSINESS ) {
                $totalCredits= $this->getParentTotalCredits($parent_id);
                $usedCredits= $this->sumParentCredits($parent_id);
                $remaining_credits = $totalCredits - $usedCredits;
                return $remaining_credits;
            }
    }

        if ($parent_id == 0 && Yii::$app->user->identity->account_type == 1) {
            $totalCredits = $this->getTotalCredits();
            $pcredits_used = UserRecords::find()->where(['user_id' => $userId , 'account_type' => self::CREDITS_PERSONAL])->sum('credit_used');
            $business_credit_assigned= User::find()->where(['parent_id' => $userId])->sum('business_credits');
            $remaining_credits =  $totalCredits - ($pcredits_used + $business_credit_assigned);
        }
         return ($remaining_credits > 0 ) ? $remaining_credits : 0 ;
    }

    public function getTopUpCredits($id=null)
    {
        $id= is_null($id) ? Yii::$app->user->identity->id : $id;
        $creditData =  UserPlans::find()->where(['user_id' => $id])
        ->andWhere(['isExpire' => 0])
        ->andWhere(['is_cancel' => 0])
        ->andWhere(['status' => 1])->select('credits')->one();
       // UserPlans::find()->where(['user_id'=> Yii::$app->user->identity->id])->select('credits')->one();
        return empty ($creditData) ? 0 :  $creditData->credits;
    }

    public  function getTotalCredits()
    {  
        $planCredits=  $this->getTopUpCredits();
        return (Yii::$app->user->identity->personal_credits + Yii::$app->user->identity->business_credits + $planCredits);
    }
    public function getParentTotalCredits($id)
    {  
        $planCredits=  $this->getTopUpCredits($id);
        $userdata= User::findOne($id);
        return ($userdata->personal_credits + $userdata->business_credits + $planCredits);
    }

    public function getProfileImage()
    {
        if (!empty($this->profile_picture)) {
            return Yii::getAlias('@imagesUrl') . '/' . $this->profile_picture;
        } else {
            return Yii::getAlias('@web/img/blank-user.jpg');
        }
    }

    public static function limit_text($text, $limit) {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
      }


    /**
     *
     * {@inheritdoc}
     *
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function setEmailConfirmCode()
    {
        $this->confirm_code = Yii::$app->security->generateRandomString();
    }

    public function setReferalCode()
    {
        $this->referal_code = Yii::$app->security->generateRandomString(8);
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'role' => 'Role',
            'state_id' => Yii::t('app', 'State'),
            'age' => 'Age',
            'credit_type' => 'Credit Type',
            'account_type' => Yii::t('app', 'Credit Account'),
            'referal_code' => 'Referal Code',
            'personal_credits' => 'Personal Credits',
            'business_credits' => 'Business Credits',
            'contact_number' => 'Contact Number',
            'profile_picture' => 'Profile Picture',
            'business_name' => 'Business Name',
            'school_name' => 'School Name',
            'country' => 'Country',
            'state' => 'State',
            'city' => 'City',
            'zipcode' => 'Zipcode',
            'address' => 'Address',
            'street_address' => 'Street Address',
            'is_confirmed' => Yii::t('app', 'Is Confirmed'),
            'is_admin_approve' => Yii::t('app', 'Approved'),
            'confirmed_at' => Yii::t('app', 'Confirmed At'),
            'isDeleted' => Yii::t('app', 'Is Deleted'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'created_at' => Yii::t('app', 'Created On'),
            'updated_at' => Yii::t('app', 'Updated On'),
            'created_by' => Yii::t('app', 'Created By')
        ];

    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), [
            'id' => 'created_by'
        ]);
    }

    public static function findByEmailConfirmationKey($token)
    {
        return static ::findOne([
            'confirm_code' => $token,
            'state_id' => self::STATE_ACTIVE,
        ]);
    }

    public static function findByPasswordResetToken($token)
    {
        if (!static ::isPasswordResetTokenValid($token))
        {
            return null;
        }
        return static ::findOne([
            'password_reset_token' => $token,
            'state_id' => self::STATE_ACTIVE,
        ]);
    }

    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token))
        {
            return false;
        }
        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }
    
    public static function isReferalCodeValid($token)
    {
        if (empty($token))
        {
            return false;
        }
        return static ::findOne([
            'referal_code' => $token
        ]);
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function removeEmailConfirmationToken()
    {
        $this->confirm_code = null;
    }

   public function getParentIDByReferalCode($referal_code){
     
       return $this->find()->where(['referal_code' => $referal_code])->one();
   }

   public  function getCategories()
    {
        return $this->hasOne(UserCategories::className(), ['id' => 'user_category_id']);
    }


    public  function getPlans()
    {
        return $this->hasOne(UserPlans::className(), ['user_id' => 'id']);
    }

    public function getNonExpirePlans()
    {
        return $this->hasMany(UserPlans::className(), ['user_id' => 'id']);
    }

    public  function getReferrals()
    {
        return $this->hasMany(User::className(), ['parent_id' => 'id']);
    }

    
        public function sendTestEmail($user_id){
        $user = User::findOne([
            'id' => $user_id
        ]);
     
       $data = Yii::$app
        ->mailer
        ->compose(
            ['html' => 'test-html'],
            ['user' => $user]
        )
        ->setFrom([Yii::$app->params['supportEmail'] => 'Nocopycopy'])
        ->setTo($this->email)
        ->setSubject('Plan Expire Notification for Nocopycopy')
        ->send();
        return $data;
        
    }
    public function sendEmailNotificationExpirePlan($user_id)
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
                ['html' => 'sendEmailNotificationExpiryPlan-html'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => 'Nocopycopy'])
            ->setTo($this->email)
            ->setSubject('Plan Expire for Nocopycopy')
            ->send();
    }

    public function sendEmailNotificationCreditLow($user_id)
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
                ['html' => 'sendEmailNotificationCreditLow-html'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => 'Nocopycopy'])
            ->setTo($this->email)
            ->setSubject('Plan Expire Notification for Nocopycopy')
            ->send();
    }
    

       public function sendUserApproveEmail($user_id)
    {
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
            ->setSubject('Account Approved')
            ->send();
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
            ->setSubject('Account Reject')
            ->send();
    }


    
}