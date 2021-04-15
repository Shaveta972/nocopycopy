<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auth}}`.
 */
class m190605_050609_create_auth_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%auth}}', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer(10)->unsigned()->notNull(),
            'source' => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
            'deleted_at' => $this->integer()->unsigned()->null(),
            'created_at' => $this->integer()->unsigned()->null(),
            'updated_at' => $this->integer()->unsigned()->null(),
            'created_by' => $this->integer()->unsigned()->null(),
            'isDeleted' => $this->integer()->unsigned()->null()
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createIndex(
            'idx-tbl_auth-user_id',
            'tbl_auth',
            'user_id'
        );
     $this->addForeignKey('fk_auth_user_id', 'tbl_auth', 'user_id', 'tbl_user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%auth}}');
        // $this->dropForeignKey(
        //     'fk-tbl_auth-user_id-user-id',
        //     'auth'
        // );  
    }
}