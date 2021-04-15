<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_auth".
 *
 * @property int $id
 * @property int $user_id
 * @property string $source
 * @property string $source_id
 *
 */
class Auth extends \app\models\BaseActiveRecord
{
	/**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_auth';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'source', 'source_id'], 'required'],
            [['user_id'], 'integer'],
            [['source', 'source_id'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'source' => 'Source',
            'source_id' => 'Source Id',
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'created_at' => Yii::t('app', 'Created On'),
            'updated_at' => Yii::t('app', 'Updated On'),
            'create_user_id' => Yii::t('app', 'Created By')
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\AuthQuery the active query used by this AR class.
     */
    public static function find()
    {
        return (new \app\models\query\AuthQuery(get_called_class()))->where([
        		'isDeleted'=>0
        ]);
    }

    public function getUser()
    {
        return $this->hasOne(User::class,['id' => 'user_id']);
    }
}
