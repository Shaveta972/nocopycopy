<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_user_request".
 *
 * @property int $id
 * @property string $process_id
 * @property string $result_id
 * @property string $result_text
 * @property string $url
 * @property string $title
 * @property string $percents
 * @property int $number_copied_words
 * @property string $cached_version
 * @property string $introduction
 * @property int $deleted_at
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $isDeleted
 */
class UserRequest extends \app\models\BaseActiveRecord
{

    /**
     *
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_user_request';
    }

    /**
     *
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
               [
                    'process_id'
                ],
                'required'
            ],
            [
                [
                    'number_copied_words',
                  
                    'created_by'
                ],
                'integer'
            ],
            [
                [
                      'result_id',
                    'result_text',
                    'process_id',
                    'url',
                    'title',
                    'percents',
                    'cached_version'
                ],
                'string'
            ]
        ];
    }

    /**
     *
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'result_id' => 'Result Id',
            'process_id' => 'Process',
            'url' => 'Url',
            'title' => 'Title',
            'percents' => 'Percents',
            'number_copied_words' => 'Number Copied Words',
            'cached_version' => 'Cached Version',
            'isDeleted' => Yii::t('app', 'Is Deleted'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'created_at' => Yii::t('app', 'Created On'),
            'updated_at' => Yii::t('app', 'Updated On'),
            'created_by' => Yii::t('app', 'Created By')
        ];
    }

    /**
     *
     * {@inheritdoc}
     * @return UserRequestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return (new UserRequestQuery(get_called_class()))->where([
            'isDeleted' => 0
        ]);
    }
}
