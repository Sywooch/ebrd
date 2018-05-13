<?php

use yii\db\Migration;

/**
 * Handles adding published_at to table `blog_post`.
 */
class m171102_124455_add_published_at_column_to_blog_post_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('blog_post', 'published_at', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('blog_post', 'published_at');
    }
}
