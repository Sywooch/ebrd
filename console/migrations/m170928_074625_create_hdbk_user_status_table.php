<?php

use yii\db\Migration;

/**
 * Handles the creation of table `hdbk_user_status`.
 */
class m170928_074625_create_hdbk_user_status_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('hdbk_user_status', [
            'id' => $this->primaryKey(),
			'name' => $this->string(),
			'description' => $this->text(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('hdbk_user_status');
    }
}
