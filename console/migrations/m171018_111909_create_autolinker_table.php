<?php

use yii\db\Migration;

/**
 * Handles the creation of table `autolinker`.
 */
class m171018_111909_create_autolinker_table extends Migration
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
		
		$this->createTable('plugins__autolinker', [
            'id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
            'title' => 'VARCHAR(190) NOT NULL',
            'keywords' => 'TEXT NOT NULL',
            'url' => 'VARCHAR(255) NOT NULL',
            'links_quantity' => 'INT(3) NOT NULL',
            'target' => 'VARCHAR(255) NULL',
            'lang' => 'VARCHAR(255) NULL',
            'info' => 'TEXT NULL',
            'created_at' => 'TIMESTAMP NULL',
            'updated_at' => 'TIMESTAMP NULL',
            0 => 'PRIMARY KEY (`id`)'
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('plugins__autolinker');
    }
}