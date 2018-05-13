<?php

use yii\db\Migration;

class m171010_114239_create_table_hdbk_post_status extends Migration
{
    public function safeUp()
    {		
        $this->createTable('blog_hdbk_post_status', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'description' => $this->text(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('blog_hdbk_post_status');
    }
}
