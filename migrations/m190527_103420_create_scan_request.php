<?php

use yii\db\Migration;

/**
 * Class m190527_103420_create_scan_request
 */
class m190527_103420_create_scan_request extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%scan_request}}', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned(),
            'process_id' => $this->string()->notNull()->unique(),
            'process_type' => $this->string()->notNull(),
            'process_value' => $this->text()->notNull(),
            'total_results' => $this->integer(11)->defaultValue(0),
            'state_id' => $this->tinyInteger(1)->defaultValue(0),
            'deleted_at' => $this->integer()->unsigned()->null(),
            'created_at' => $this->integer()->unsigned()->null(),
            'updated_at' => $this->integer()->unsigned()->null(),
            'created_by' => $this->integer()->unsigned()->null(),
            'isDeleted' => $this->integer()->unsigned()->defaultValue(0)
        ],$tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%scan_request}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190527_103420_create_scan_request cannot be reverted.\n";

        return false;
    }
    */
}
