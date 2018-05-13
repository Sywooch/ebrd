<?php

use yii\db\Migration;

/**
 * Handles the creation of table `plugins__autolinker_global_settings`.
 */
class m171026_144703_create_plugins__autolinker_global_settings_table extends Migration
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
        $this->createTable('plugins__autolinker_global_settings', [
            'id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
			'setting_name' => 'VARCHAR(255) NOT NULL',
			'setting_description' => 'VARCHAR(255) NOT NULL',
			'settings_value' => 'VARCHAR(255) NOT NULL',
			'lang_id' => 'INT(11) NULL',
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
        $this->dropTable('plugins__autolinker_global_settings');
    }
}
