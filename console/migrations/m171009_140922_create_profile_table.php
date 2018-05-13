<?php

use yii\db\Migration;

/**
 * Handles the creation of table `profile`.
 */
class m171009_140922_create_profile_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('profile', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'user_first_name' => $this->string(),
            'user_last_name' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('profile');
    }
}
