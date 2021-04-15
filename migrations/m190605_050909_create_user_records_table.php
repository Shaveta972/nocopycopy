<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_records}}`.
 */
class m190605_050909_create_user_records_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_records}}', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned(),
            'process_id' => $this->string()->notNull()->unique(),
            'process_type' => $this->string()->notNull(),
            'process_value' => $this->text()->notNull(),
            'total_results' => $this->integer(11)->defaultValue(0),
            'credit_used' => $this->integer(11)->defaultValue(0),
            'account_type' => "ENUM('1', '2')",
            'state_id' => $this->tinyInteger(1)->defaultValue(0),
            'deleted_at' => $this->integer()->unsigned()->null(),
            'created_at' => $this->integer()->unsigned()->null(),
            'updated_at' => $this->integer()->unsigned()->null(),
            'created_by' => $this->integer()->unsigned()->null(),
            'isDeleted' => $this->integer()->unsigned()->defaultValue(0)
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_records}}');
    }
}
