<?php

use yii\db\Migration;

/**
 * Class m171117_100616_add_thumbnail_column_tbot_new_message
 */
class m171117_100616_add_thumbnail_column_tbot_new_message extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
		$this->addColumn('tbot_new_message', 'thumbnail', $this->integer(11));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('tbot_new_message', 'thumbnail', $this->integer(11));
	}
}
