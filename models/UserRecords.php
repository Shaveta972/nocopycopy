<?php
namespace app\models;

use Yii;
use Copyleaks\CopyleaksCloud;
use Copyleaks\CopyleaksProcess;
use Copyleaks\Products;
use app\models\UserRequest;

/**
 * This is the model class for table "tbl_user_records".
 *
 * @property int $id
 * @property int $user_id
 * @property string $subject_code
 * @property string $process_id
 * @property string $process_type
 * @property string $process_value
 * @property int $credit_used
 * @property int $deleted_at
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $isDeleted
 */
class UserRecords extends \app\models\BaseActiveRecord
{

    const STATE_COMPLETED = 1;
    const STATE_PENDING = 0;

    /**
     *
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_user_records';
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
                    'user_id',
                    'created_by'
                ],
                'integer'
            ],
            [
                [
                    'process_value'
                ],
                'required',
                'message' => 'Please enter text to scan.',
                'on' => 'text'
            ],
         
            [
                [
                    'process_value'
                ],
                'required',
                'message' => 'Please enter URL to scan.',
                'on' => 'url'
            ],
            [['credit_used','total_results' ,'results'], 'safe'],
            [['subject_code'], 'string'],
            [
                [
                    'process_id',
                    'process_type',
                    'process_value'
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
            'user_id' => 'User',
            'process_id' => 'Process',
            'process_type' => 'Process Type',
            'process_value' => 'Process Value',
            'subject_code' => 'Subject',
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
     * @return UserRecordsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return (new UserRecordsQuery(get_called_class()))->where([
            'isDeleted' => 0
        ]);
    }

    public static function getState($id)
    {
        $options = self::getStateOptions();
        return isset($options[$id]) ? $options[$id] : 'NA';
    }

    public static function getStateOptions()
    {
        return [
            self::STATE_PENDING => 'Pending',
            self::STATE_COMPLETED => 'Completed'
        ];
    }

    public  function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
  
    public static function getResult($id){
    $data=   UserRequest::find()->where(['process_id' => $id ])->distinct()->groupBy('url')->average('percents');
 
        return ($data) ? "<span class='badge-blue'>".$data."%". "</span>" : 'No Result Found';
    }
}

// ->average('percents')