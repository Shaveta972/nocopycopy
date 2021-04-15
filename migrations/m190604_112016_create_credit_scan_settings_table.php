<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%credit_scan_settings}}`.
 */
class m190604_112016_create_credit_scan_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%credit_scan_settings}}', [
            'id' => $this->primaryKey(),
            'doc_type' => "ENUM('text', 'url', 'file')",
            'credit_value' => $this->integer()->notNull(),
            'deleted_at' => $this->integer()->unsigned()->null(),
            'created_at' => $this->integer()->unsigned()->notNull(),
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
        $this->dropTable('{{%credit_scan_settings}}');
    }
}
