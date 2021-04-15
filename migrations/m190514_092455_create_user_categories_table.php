<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_categories}}`.
 */ 

class m190514_092455_create_user_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_categories}}', [
            'id' => $this->primaryKey(),
            'category_type' => "ENUM('Individual', 'Education', 'Business')",
            'category_name' =>  $this->string()->notNull(),
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
        $this->dropTable('{{%user_categories}}');
    }
}
