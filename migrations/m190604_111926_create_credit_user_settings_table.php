<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%credit_user_settings}}`.
 */
class m190604_111926_create_credit_user_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%credit_user_settings}}', [
            'id' => $this->primaryKey(),
            'user_category_id' =>  $this->integer()->notNull(),
            'credit_value' => $this->integer()->notNull(),
            'deleted_at' => $this->integer()->unsigned()->null(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->null(),
            'created_by' => $this->integer()->unsigned()->null(),
            'isDeleted' => $this->integer()->unsigned()->defaultValue(0)
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createIndex(
            'idx-tbl_credit_user_settings-user_category_id',
            'tbl_user',
            'user_category_id'
        );
            $this->addForeignKey('fk_user_category_id', 'tbl_credit_user_settings', 'user_category_id', 'tbl_user_categories', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%credit_user_settings}}');
    }
}
