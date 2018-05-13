<?php

use yii\db\Migration;

/**
 * Handles dropping uk from table `blog_map_entity_lang`.
 */
class m171003_115503_drop_uk_column_from_blog_map_entity_lang_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('blog_map_entity_lang', 'uk');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('blog_map_entity_lang', 'uk', $this->integer());
    }
}
