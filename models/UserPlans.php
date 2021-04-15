<?php

namespace app\models;
use Yii;

/**
 * This is the model class for table "tbl_user_plans".
 *
 * @property int $id
 * @property string $reference_id
 * @property int $user_id
 * @property int $plan_id
 * @property int $status
 * @property int $isExpire
 * @property int $credits
 * @property int $expiration_date
 * @property int $deleted_at
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $isDeleted
 */
class UserPlans extends \app\models\BaseActiveRecord
{
    public $first_name;
    public $last_name;
    public $email;
    public $plan_name;
    public $amount_paid;
    public $title;
    public $state_id;
    public $isExpire;


	/**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_user_plans';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reference_id', 'user_id', 'plan_id'], 'required'],
            [['user_id', 'plan_id', 'status', 'isExpire','is_cancel','credits', 'expiration_date', 'created_by'], 'integer'],
            [['reference_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reference_id' => 'Reference',
            'user_id' => 'User',
            'plan_id' => 'Plan',
            'status' => 'Status',
            'isExpire' => 'Is Expire',
             'is_cancel' => 'Cancel',
            'credits' => 'Credits',
            'expiration_date' => 'Expiration Date',
            'isDeleted' => Yii::t('app', 'Is Deleted'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'created_at' => Yii::t('app', 'Paid at'),
            'updated_at' => Yii::t('app', 'Updated On'),
            'created_by' => Yii::t('app', 'Created By')
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserPlansQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return (new UserPlansQuery(get_called_class()))->where([
    //     		'isDeleted'=>0
    //     ]);
    // }
    public  function getPlans()
    {
        return $this->hasOne(Plans::className(), ['id' => 'plan_id']);
    }

     /**
     * Sends an email with a link, for sending the expire plan information.
     *
     * @return bool whether the email was send
     */
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


    
}
