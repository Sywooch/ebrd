<?php

use yii\db\Migration;

/**
 * Handles dropping published from table `blog_post`.
 */
class m171108_134038_drop_published_column_from_blog_post_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('blog_post', 'published');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('blog_post', 'published', $this->integer());
    }
}
