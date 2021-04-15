<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_enquiries".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone_number
 * @property int $deleted_at
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $isDeleted
 */
class Enquiries extends \app\models\BaseActiveRecord
{
	/**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_enquiries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'phone_number'], 'required'],
            [['created_by'], 'integer'],
            [['email'], 'email'],
            [['message'], 'string', 'max' => 300],
            [['first_name', 'last_name', 'email', 'phone_number'], 'string', 'max' => 255],
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
            'email' => 'Email',
            'phone_number' => 'Phone Number',
            'message' => 'Message',
            'deleted_at' => 'Deleted At',
            'created_at' => 'Created On',
            'updated_at' => 'Updated On',
            'created_by' => 'Created By',
            'isDeleted' => 'Is Deleted',
        ];
    }

    public function sendAutoReplyEmail($user){
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'customerServiceEmail-html'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => 'Nocopycopy'])
            ->setTo($this->email)
            ->setSubject('Auto Reply from Nocopycopy')
            ->send();
    }

}
