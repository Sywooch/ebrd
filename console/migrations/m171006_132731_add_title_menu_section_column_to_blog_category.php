<?php

use yii\db\Migration;

class m171006_132731_add_title_menu_section_column_to_blog_category extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('blog_category', 'title', $this->string());
		$this->addColumn('blog_category', 'menu_section', $this->string());
    }
}
