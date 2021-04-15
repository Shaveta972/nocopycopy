<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_user_categories".
 *
 * @property int $id
 * @property string $category_type
 * @property string $category_name
 * @property int $deleted_at
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $isDeleted
 */
class UserCategories extends \app\models\BaseActiveRecord
{
	/**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_user_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_type', 'category_name'], 'required'],
            [['category_type'], 'string'],
            [['created_by'], 'integer'],
            [['category_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_type' => 'Category Type',
            'category_name' => 'Category Name',
            'isDeleted' => Yii::t('app', 'Is Deleted'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'created_at' => Yii::t('app', 'Created On'),
            'updated_at' => Yii::t('app', 'Updated On'),
            'created_by' => Yii::t('app', 'Created By')
        ];
    }



    public function findCategoryNameByID($id)
    {
        return $this->findOne($id);
    }

    public function findAllUserCategories()
    {
        return $this->find()->select(['id','category_name','category_type'])->all();
    }
}
