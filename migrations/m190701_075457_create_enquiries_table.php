<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%enquiries}}`.
 */
class m190701_075457_create_enquiries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%enquiries}}', [
            'id' => $this->primaryKey(),
            'first_name'=> $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'phone_number' => $this->string()->notNull(),
            'message' => $this->text()->null(),
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
        $this->dropTable('{{%enquiries}}');
    }
}
