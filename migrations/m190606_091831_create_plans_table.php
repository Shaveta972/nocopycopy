<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%plans}}`.
 */
class m190606_091831_create_plans_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%plans}}', [
            'id' => $this->primaryKey()->unsigned(),
            'user_category_id' => $this->integer(10)->unsigned()->notNull(),
            'title' => $this->string(255)->notNull(),
            'price_usd' => $this->integer()->notNull(),
            'price_naira' => $this->integer()->notNull(),
            'number_credits' => $this->string()->notNull(),
            'validity' => $this->integer()->unsigned()->null(),
            'deleted_at' => $this->integer()->unsigned()->null(),
            'created_at' => $this->integer()->unsigned()->null(),
            'updated_at' => $this->integer()->unsigned()->null(),
            'created_by' => $this->integer()->unsigned()->null(),
            'isDeleted' => $this->integer()->unsigned()->null()
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createIndex(
            'idx-tbl_plans-user_category_id',
            'tbl_plans',
            'user_category_id'
        );
       // $this->addForeignKey('fk_user_category_id', 'tbl_plans', 'user_category_id', 'tbl_user_categories', 'id');
         
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%plans}}');
    }
}
