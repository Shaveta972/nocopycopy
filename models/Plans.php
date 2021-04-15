<?php

namespace app\models;

use Yii;
use app\models\UserCategories;

/**
 * This is the model class for table "tbl_plans".
 *
 * @property int $id
 * @property int $user_category_id
 * @property string $title
 * @property int $price
 * @property string $currency
 * @property string $number_credits
 * @property string $number_words
 * @property int $validity
 * @property int $is_published
 * @property int $deleted_at
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $isDeleted
 */
class Plans extends \app\models\BaseActiveRecord
{
	/**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_plans';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_category_id', 'price', 'validity', 'created_by'], 'integer'],
            [['title', 'price', 'number_credits','currency','is_published'], 'required'],
            [['title', 'number_credits','number_words'], 'string', 'max' => 255],
            // [['user_category_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
         'id' => Yii::t('app', 'ID'),
            'user_category_id' => 'User Category',
            'title' => 'Title',
            'price' => 'Price',
            'currency' => 'Currency',
            'number_words' => 'Words Count',
            'is_published' => 'Publish Status',
            'number_credits' => 'Number Credits',
            'validity' => 'Validity (in months)',
            'isDeleted' => Yii::t('app', 'Is Deleted'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'created_at' => Yii::t('app', 'Created On'),
            'updated_at' => Yii::t('app', 'Updated On'),
            'created_by' => Yii::t('app', 'Created By')
        ];
    }   

    public  function getCategories()
    {
        return $this->hasOne(UserCategories::className(), ['id' => 'user_category_id']);
    }

    public function getUserPlans()
    {
        return $this->hasOne(UserPlans::className(), ['plan_id' => 'id']);
    }
}
