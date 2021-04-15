<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_plans}}`.
 */
class m190619_063633_create_user_plans_table extends Migration
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
        $this->createTable('{{%user_plans}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(10)->unsigned()->notNull(),
            'plan_id' => $this->integer()->unsigned()->notNull(),
            'credits' => $this->integer()->unsigned()->notNull(),
            'reference_id' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'is_cancel' => $this->smallInteger()->notNull()->defaultValue(0),
            'isExpire' => $this->smallInteger()->notNull()->defaultValue(0),
            'expiration_date' => $this->integer()->unsigned()->null(),
            'deleted_at' => $this->integer()->unsigned()->null(),
            'created_at' => $this->integer()->unsigned()->null(),
            'updated_at' => $this->integer()->unsigned()->null(),
            'created_by' => $this->integer()->unsigned()->null(),
            'isDeleted' => $this->integer()->unsigned()->null()
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createIndex(
            'idx-tbl_user_plans-user_id',
            'tbl_user_plans',
            'user_id'
        );

             $this->addForeignKey('fk_user_id', 'tbl_user_plans', 'user_id', 'tbl_user', 'id','CASCADE', 'CASCADE');
        
            $this->createIndex(
                'idx-tbl_user_plans-plan_id',
                'tbl_user_plans',
                'plan_id'
            );
        //   $this->addForeignKey('fk_plan_id', 'tbl_user_plans', 'plan_id', 'tbl_plans', 'id','CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_plans}}');
    }
}
