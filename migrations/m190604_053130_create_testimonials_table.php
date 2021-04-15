<?php

use yii\db\Migration;

/**
 * Handles the creation of table'{{%testimonials}}`.
 */
class m190604_053130_create_testimonials_table extends Migration
{
    /**
     * {@inheritdoc}
     */

    public $tableName = '{{%testimonials}}';

    public function safeUp()
    {
        
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'testimonials_title' => $this->string(255)->notNull(),
            'testimonials_url'   => $this->string(255)->notNull(),
           'testimonials_name' => $this->text()->notNull(),
           'testimonials_image' => $this->string(255)->notNull(),
           'testimonials_html_text' => $this->text()->notNull(),
           'testimonials_mail'     => $this->string(255)->null(),
           'testimonials_company'  => $this->string(255)->null(),
           'testimonials_city'     => $this->string(255)->null(),
           'testimonials_country'  => $this->string(255)->null(),
            'active' => $this->boolean()->notNull(),
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
        $this->dropTable('{{%testimonials}}');
    }
}
