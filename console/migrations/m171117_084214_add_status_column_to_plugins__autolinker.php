<?php

use yii\db\Migration;

/**
 * Class m171117_084214_add_status_column_to_plugins__autolinker
 */
class m171117_084214_add_status_column_to_plugins__autolinker extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
		$this->addColumn('plugins__autolinker', 'status', $this->integer(2));
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
		$this->dropColumn('plugins__autolinker', 'status', $this->integer(2));
	}

}
