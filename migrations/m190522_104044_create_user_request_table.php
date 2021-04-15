<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_request}}`.
 */
class m190522_104044_create_user_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_request}}', [
            'id' => $this->primaryKey(),
            'process_id' => $this->string()->notNull(),
            'process_type' => $this->string()->Null(),
            'process_value' => $this->string()->Null(),
            'url' => $this->string()->Null(),
            'title' => $this->string()->Null(),
            'introduction' => $this->string()->null(),
            'percents' => $this->string()->Null(),
            'number_copied_words' => $this->integer()->Null(),
            'cached_version' => $this->string()->Null(),
            'deleted_at' => $this->integer()->unsigned()->null(),
            'created_at' => $this->integer()->unsigned()->null(),
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
        $this->dropTable('{{%user_request}}');
    }
}
