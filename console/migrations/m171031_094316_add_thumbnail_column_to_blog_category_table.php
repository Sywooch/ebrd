<?php

use yii\db\Migration;

/**
 * Handles adding thumbnail to table `blog_category`.
 */
class m171031_094316_add_thumbnail_column_to_blog_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('blog_category', 'thumbnail', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('blog_category', 'thumbnail');
    }
}
