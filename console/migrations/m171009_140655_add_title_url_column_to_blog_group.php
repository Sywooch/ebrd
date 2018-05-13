<?php

use yii\db\Migration;

class m171009_140655_add_title_url_column_to_blog_group extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('blog_group', 'title', $this->string());
		$this->addColumn('blog_group', 'url', $this->string());
    }
}
