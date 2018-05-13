<?php

use yii\db\Migration;
use frontend\modules\blog\models\BlogCategory;


class m171013_112023_update_blog_hdbk_entity extends Migration
{
    public function safeUp()
    {
		$this->addColumn('blog_hdbk_entity', 'class_name', $this->string());
		$this->addColumn('blog_hdbk_entity', 'table', $this->string());
    }

    public function safeDown()
    {
        $this->dropColumn('blog_hdbk_entity', 'class_name');
        $this->dropColumn('blog_hdbk_entity', 'table');
    }
}
