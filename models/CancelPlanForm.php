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
class CancelPlanForm extends \app\models\BaseActiveRecord
{
    public $is_cancel;
    public $id;
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
            [['is_cancel','id'], 'required'],
            [['is_cancel'], 'integer'],
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
    public static function find()
    {
        return (new UserPlansQuery(get_called_class()))->where([
        		'isDeleted'=>0
        ]);
    }
   
}
