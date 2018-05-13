<?php

use yii\db\Migration;

class m171013_072401_rename_blog_hdbk_post_status extends Migration
{
    public function safeUp()
    {
		$this->renameTable('blog_hdbk_post_status', 'blog_hdbk_status');
    }

    public function safeDown()
    {
		$this->renameTable('blog_hdbk_status', 'blog_hdbk_post_status');
    }
}
