<?php

use yii\db\Migration;

class m170928_083042_rename_status_column_user_table extends Migration
{
    public function safeUp()
    {
		$this->renameColumn('user', 'status', 'status_id');
    }

    public function safeDown()
    {
        $this->renameColumn('user', 'status_id', 'status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170928_083042_rename_status_column_user_table cannot be reverted.\n";

        return false;
    }
    */
}
