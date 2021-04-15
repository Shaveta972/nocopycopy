<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */

class m190516_044813_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey()->unsigned(),
            'parent_id' => $this->integer()->unsigned(),
            'user_category_id' => $this->integer()->null()->defaultValue('0'),
            'title' => $this->string(255)->null(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'email' => $this->string()->unique()->notNull(),
            'password' => $this->string(),
            'password_reset_token' => $this->string()->unique(),
            'profile_picture' => $this->string()->null(),
            'credit_account' => $this->smallInteger()->notNull()->defaultValue(0),
            'personal_credits' => $this->integer(11)->unsigned()->defaultValue(0),
            'business_credits' => $this->integer(11)->unsigned()->defaultValue(0),
            'account_type' => 'ENUM("1", "2") DEFAULT "1" ',
            'school_name' =>$this->string()->null(),
            'business_name' => $this->string()->null(),
            'referal_code' => $this->string()->null(),
            'age' => $this->string()->null(),
            'role' => $this->smallInteger()->notNull(),
            'state_id' => $this->smallInteger()->notNull()->defaultValue(1),
            'confirm_code' => $this->string(),
            'is_confirmed' => $this->smallInteger()->notNull()->defaultValue(0),
            'address' => $this->string()->null(),
            'contact_number' => $this->string()->null(),
            'deleted_at' => $this->integer()->unsigned()->null(),
            'created_at' => $this->integer()->unsigned()->null(),
            'updated_at' => $this->integer()->unsigned()->null(),
            'created_by' => $this->integer()->unsigned()->null(),
            'isDeleted' => $this->integer()->unsigned()->null()
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
         
      $this->createIndex(
        'idx-tbl_user-user_category_id',
        'tbl_user',
        'user_category_id'
    );
       // $this->addForeignKey('fk_user_category_id', 'tbl_user', 'user_category_id', 'tbl_user_categories', 'id');
     
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropIndex(
           'idx-tbl_user-user_category_id',
           'tbl_user'
       );
        $this->dropTable('{{%user}}');
    }
}

