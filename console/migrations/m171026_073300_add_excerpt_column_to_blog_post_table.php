<?php

use yii\db\Migration;

/**
 * Handles adding excerpt to table `blog_post`.
 */
class m171026_073300_add_excerpt_column_to_blog_post_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('blog_post', 'excerpt', $this->string(255));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('blog_post', 'excerpt');
    }
}
