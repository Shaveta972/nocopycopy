<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transactions}}`.
 */
class m190612_093940_create_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transactions}}', [
            'id' => $this->primaryKey(),
            'reference_id' => $this->string()->notNull()->unique(),
            'amount_paid' =>  $this->integer()->unsigned()->notNull(),
            'domain' => $this->string(),
            'status' =>  $this->string(),
            'gateway_response' =>  $this->string(),
            'channel' =>$this->string(),
            'currency' =>$this->string(),
            'ip_address' =>$this->string(),
            'customer_code' =>$this->string(),
            'authorization_code'=>$this->string(),
            'card_type'=>$this->string(),
            'bank'=>$this->string(),
            'country_code'=>$this->string(),
            'brand'=>$this->string(),
            'signature'=>$this->string(),
            'deleted_at' => $this->integer()->unsigned()->null(),
            'created_at' => $this->integer()->unsigned()->null(),
            'updated_at' => $this->integer()->unsigned()->null(),
            'created_by' => $this->integer()->unsigned()->null(),
            'isDeleted' => $this->integer()->unsigned()->null()
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%transactions}}');
    }
}

