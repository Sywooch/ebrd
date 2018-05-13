<?php

use yii\db\Migration;

/**
 * Handles the creation of table `shortcode_info`.
 */
class m171029_171738_create_shortcode_info_table extends Migration
{
    public function safeUp()
    {		
        $this->createTable('shortcode_info', [
            'id' => $this->primaryKey(),
            'shortcode_id' => $this->integer(),
            'tag' => $this->string(),
            'description' => $this->text(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('shortcode_info');
    }
}
