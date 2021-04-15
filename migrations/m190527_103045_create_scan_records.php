<?php

use yii\db\Migration;

/**
 * Class m190527_103045_create_scan_records
 */
class m190527_103045_create_scan_records extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%scan_records}}', [
            'id' => $this->primaryKey(),
            'process_id' => $this->string()->notNull(),
            'url' => $this->string()->Null(),
            'title' => $this->text()->Null(),
            'introduction' => $this->text()->null(),
            'percents' => $this->string()->Null(),
            'number_copied_words' => $this->integer()->Null(),
            'cached_version' => $this->string()->Null(),
            'deleted_at' => $this->integer()->unsigned()->null(),
            'created_at' => $this->integer()->unsigned()->null(),
            'updated_at' => $this->integer()->unsigned()->null(),
            'created_by' => $this->integer()->unsigned()->null(),
            'isDeleted' => $this->integer()->unsigned()->defaultValue(0)
        ], $tableOptions);
        
        // $this->addForeignKey(
        //     'fk-tbl_scan_records-process_id',
        //     'tbl_scan_records',
        //     'process_id',
        //     'tbl_scan_request',
        //     'process_id'
        // );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%scan_records}}');
        // drops foreign key for table `user`
        // $this->dropForeignKey(
        //     'fk-tbl_scan_records-process_id',
        //     'process_id'
        // );
        echo "m190527_103045_create_scan_records cannot be reverted.\n";
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190527_103045_create_scan_records cannot be reverted.\n";

        return false;
    }
    */
}
