<?php

use yii\db\Migration;

class m171006_132854_add_title_menu_section_column_to_blog_post extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('blog_post', 'title', $this->string());
		$this->addColumn('blog_post', 'menu_section', $this->string());
    }
}
