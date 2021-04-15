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
 * @property string $email
 * @property string $password
 * @property int $role
 * @property int $state_id
 * @property int $isDeleted
 * @property int $deleted_at
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 *
 * @property UserEditProfile $createdBy
 * @property UserEditProfile[] $userEditProfiles
 */
class UserEditProfile extends \app\models\BaseActiveRecord
{
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
            [['first_name', 'last_name', 'username', 'email', 'age', 'role','state','country','city'], 'required'],
            [['role', 'state_id', 'created_by'], 'integer'],
            [['first_name', 'last_name', 'username', 'email', 'password'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => UserEditProfile::className(), 'targetAttribute' => ['created_by' => 'id']],
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
            'email' => 'Email',
            'age' => 'Age',
            'password' => 'Password',
            'role' => 'Role',
            'state_id' => 'State',
            'country' => 'Country',
            'state' => 'State',
            'city' => 'city',
            'isDeleted' => 'Is Deleted',
            'deleted_at' => 'Deleted At',
            'created_at' => 'Created On',
            'updated_at' => 'Updated On',
            'created_by' => 'Created By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(UserEditProfile::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEditProfiles()
    {
        return $this->hasMany(UserEditProfile::className(), ['created_by' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return (new \app\models\query\UserQuery(get_called_class()))->where([
        		'isDeleted'=>0
        ]);
    }
}
