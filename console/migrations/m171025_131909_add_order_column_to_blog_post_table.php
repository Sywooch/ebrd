<?php

use yii\db\Migration;

/**
 * Handles adding order to table `blog_post`.
 */
class m171025_131909_add_order_column_to_blog_post_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('blog_post', 'order', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('blog_post', 'order');
    }
}
