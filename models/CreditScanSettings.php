<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_credit_scan_settings".
 *
 * @property int $id
 * @property string $doc_type
 * @property int $credit_value
 * @property int $deleted_at
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $isDeleted
 */
class CreditScanSettings extends \app\models\BaseActiveRecord
{
	/**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_credit_scan_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doc_type'], 'string' ],
            ['doc_type', 'unique'],
            [['credit_value','doc_type'], 'required'],
            [['credit_value', 'created_by'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'doc_type' => 'Doc Type',
            'credit_value' => 'Credit Value',
            'deleted_at' => 'Deleted At',
            'created_at' => 'Created On',
            'updated_at' => 'Updated On',
            'created_by' => 'Created By',
            'isDeleted' => 'Is Deleted',
        ];
    }
}
