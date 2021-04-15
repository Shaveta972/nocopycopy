<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_testimonials".
 *
 * @property int $id
 * @property string $testimonials_title
 * @property string $testimonials_url
 * @property string $testimonials_name
 * @property string $testimonials_image
 * @property string $testimonials_html_text
 * @property string $testimonials_mail
 * @property string $testimonials_company
 * @property string $testimonials_city
 * @property string $testimonials_country
 * @property int $active
 * @property int $deleted_at
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $isDeleted
 */
class Testimonials extends \app\models\BaseActiveRecord
{
	/**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_testimonials';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['testimonials_title', 'testimonials_url', 'testimonials_name', 'testimonials_html_text'], 'required'],
            [['testimonials_name', 'testimonials_html_text'], 'string'],
            [['active'], 'required', 'message' => 'Please select status'],
            [['testimonials_image'], 'safe'],
            [['testimonials_image'], 'file', 'extensions'=>'jpg, gif, png'],
            // [['testimonials_image'], 'file', 'extensions' => 'png, jpg', 'on' => 'create'],
            [['testimonials_image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'on' => 'update'],
            [['active', 'created_by'], 'integer'],
            [['testimonials_title', 'testimonials_url', 'testimonials_image', 'testimonials_mail', 'testimonials_company', 'testimonials_city', 'testimonials_country'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'testimonials_title' => 'Testimonials Title',
            'testimonials_url' => 'Testimonials Url',
            'testimonials_name' => 'Author Name',
            'testimonials_image' => 'Image',
            'testimonials_html_text' => 'Description',
            'testimonials_mail' => 'Testimonials Mail',
            'testimonials_company' => 'Testimonials Company',
            'testimonials_city' => 'Testimonials City',
            'testimonials_country' => 'Testimonials Country',
            'active' => 'Active',
            'isDeleted' => Yii::t('app', 'Is Deleted'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'created_at' => Yii::t('app', 'Created On'),
            'updated_at' => Yii::t('app', 'Updated On'),
            'created_by' => Yii::t('app', 'Created By')
        ];
    }

    public function getToggleItems()
    {
      // custom array for toggle update
      return  [
        'on' => ['value'=>1, 'label'=>'Publish'],
        'off' => ['value'=>0, 'label'=>'Panding'],
      ];
    }
}
