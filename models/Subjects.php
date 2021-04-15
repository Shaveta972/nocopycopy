<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_subjects".
 *
 * @property int $id
 * @property int $user_id
 * @property string $subject_name
 * @property string $subject_code
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 * @property int $created_by
 * @property int $isDeleted
 */
class Subjects extends \app\models\BaseActiveRecord
{
	/**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_subjects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject_name', 'subject_code'], 'required'],
            [['subject_code'], 'unique'],
            [['subject_name'], 'unique'],
            [['user_id', 'created_by'], 'integer'],
            [['subject_name', 'subject_code'], 'string', 'max' => 255],
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
            'subject_name' => 'Subject Name',
            'subject_code' => 'Subject Code',
            'isDeleted' => Yii::t('app', 'Is Deleted'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'created_at' => Yii::t('app', 'Created On'),
            'updated_at' => Yii::t('app', 'Updated On'),
            'created_by' => Yii::t('app', 'Created By')
        ];
    }
}
