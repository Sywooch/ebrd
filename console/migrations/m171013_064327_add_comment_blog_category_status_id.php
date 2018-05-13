<?php

use yii\db\Migration;

class m171013_064327_add_comment_blog_category_status_id extends Migration
{
    public function safeUp()
    {
		$this->alterColumn('blog_category', 'status_id', $this->integer()->defaultValue(frontend\modules\blog\models\BlogCategory::STATUS_DRAFT));
    }

    public function safeDown()
    {
        $this->alterColumn('blog_category', 'status_id', $this->integer()->defaultValue(NULL));
    }
}
