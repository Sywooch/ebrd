<?php

use yii\db\Migration;

/**
 * Class m171117_151054_add_image_caption_column_to_tbot_new_message
 */
class m171117_151054_add_image_caption_column_to_tbot_new_message extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
		$this->addColumn('tbot_new_message', 'image_caption', $this->string(255));
		$this->addColumn('tbot_new_message', 'path_to_video', $this->string(255));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('tbot_new_message', 'image_caption', $this->string(255));
		$this->dropColumn('tbot_new_message', 'path_to_video', $this->string(255));
    }
}
