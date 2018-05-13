<?php

use yii\db\Migration;

/**
 * Handles adding uk to table `blog_map_entity_lang`.
 */
class m170922_104428_add_uk_column_to_blog_map_entity_lang_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('blog_map_entity_lang', 'uk', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('blog_map_entity_lang', 'uk');
    }
}
