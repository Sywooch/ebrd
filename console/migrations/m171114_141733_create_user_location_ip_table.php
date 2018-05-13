<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_location_ip`.
 */
class m171114_141733_create_user_location_ip_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_location_ip', [
            'id' => $this->primaryKey(),
			'user_ip' => $this->string(),
			'time_counter' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user_location_ip');
    }
}
