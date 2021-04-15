<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_transactions".
 *
 * @property int $id
 * @property string $reference_id
 * @property int $amount_paid
 * @property string $domain
 * @property string $status
 * @property string $gateway_response
 * @property string $channel
 * @property string $currency
 * @property string $ip_address
 * @property string $customer_code
 * @property string $authorization_code
 * @property string $card_type
 * @property string $bank
 * @property string $country_code
 * @property string $brand
 * @property string $signature
 * @property int $deleted_at
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $isDeleted
 */
class Transactions extends \app\models\BaseActiveRecord
{
	/**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_transactions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reference_id', 'amount_paid'], 'required'],
            [['amount_paid', 'created_by'], 'integer'],
            [['reference_id', 'domain', 'status', 'gateway_response', 'channel', 'currency', 'ip_address', 'customer_code', 'authorization_code', 'card_type', 'bank', 'country_code', 'brand', 'signature'], 'string', 'max' => 255],
            [['reference_id'], 'unique'],
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
            'amount_paid' => 'Amount Paid',
            'domain' => 'Domain',
            'status' => 'Status',
            'gateway_response' => 'Gateway Response',
            'channel' => 'Channel',
            'currency' => 'Currency',
            'ip_address' => 'Ip Address',
            'customer_code' => 'Customer Code',
            'authorization_code' => 'Authorization Code',
            'card_type' => 'Card Type',
            'bank' => 'Bank',
            'country_code' => 'Country Code',
            'brand' => 'Brand',
            'signature' => 'Signature',
            'deleted_at' => 'Deleted At',
            'created_at' => 'Created On',
            'updated_at' => 'Updated On',
            'created_by' => 'Created By',
            'isDeleted' => 'Is Deleted',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TransactionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return (new TransactionsQuery(get_called_class()))->where([
        		'isDeleted'=>0
        ]);
    }
}
