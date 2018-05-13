<?php

use yii\db\Migration;

/**
 * Handles adding thumbnail to table `blog_post`.
 */
class m171025_145532_add_thumbnail_column_to_blog_post_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('blog_post', 'thumbnail', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('blog_post', 'thumbnail');
    }
}
