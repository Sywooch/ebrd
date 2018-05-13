<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tbot_commands`.
 */
class m171120_153106_create_tbot_commands_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('tbot_commands', [
            'id' => $this->primaryKey(),
			'commands_id' => $this->integer(),
			'command_type' => $this->string(),
			'message_from_user' => $this->string(),
			'bot_answer' => $this->string(),
			'info' => $this->string(),
			'created_at' => 'TIMESTAMP NULL',
            'updated_at' => 'TIMESTAMP NULL',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('tbot_commands');
    }
}
