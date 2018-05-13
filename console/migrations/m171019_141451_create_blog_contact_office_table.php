<?php

use yii\db\Migration;

/**
 * Handles the creation of table `blog_contact_office`.
 */
class m171019_141451_create_blog_contact_office_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
		if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
		
		$this->createTable('blog_contact_office', [
            'id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
            'alias' => 'VARCHAR(255) NOT NULL',
            'office_name' => 'VARCHAR(255) NOT NULL',
            'title' => 'VARCHAR(255) NULL',
			'menu_section' => 'VARCHAR(255)NOT NULL',
			'content' => 'TEXT NULL',
			'office_country' => 'VARCHAR(255)NOT NULL',
			'office_address' => 'VARCHAR(255)NOT NULL',
			'email' => 'VARCHAR(255)NOT NULL',
			'phone' => 'VARCHAR(255) NOT NULL',
			'contact_ip' => 'VARCHAR(255) NULL',
            'lang_name' => 'VARCHAR(255) NULL',
            'created_at' => $this->timestamp()->null(),
			'updated_at' => $this->timestamp()->null(),
            0 => 'PRIMARY KEY (`id`)'
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('blog_contact_office');
    }
}
