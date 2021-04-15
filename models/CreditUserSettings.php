<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_credit_user_settings".
 *
 * @property int $id
 * @property string $user_category_id
 * @property int $credit_value
 * @property int $deleted_at
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $isDeleted
 */
class CreditUserSettings extends \app\models\BaseActiveRecord
{
	/**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_credit_user_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_category_id', 'credit_value'], 'required'],
            ['user_category_id', 'unique'],
            [['credit_value', 'created_by'], 'integer'],
            [['user_category_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_category_id' => 'User Type',
            'credit_value' => 'Credit Value',
            'deleted_at' => 'Deleted At',
            'created_at' => 'Created On',
            'updated_at' => 'Updated On',
            'created_by' => 'Created By',
            'isDeleted' => 'Is Deleted',
        ];
    }

    /**
     * Get Credits by ID
     */
    
    public function findCreditsByID($user_category_id)
    { 
        return $this->find()->select('credit_value')->where(['user_category_id' => $user_category_id])->one();
    }
}
