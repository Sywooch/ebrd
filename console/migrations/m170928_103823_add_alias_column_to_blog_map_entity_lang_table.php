<?php

use yii\db\Migration;

/**
 * Handles adding alias to table `blog_map_entity_lang`.
 */
class m170928_103823_add_alias_column_to_blog_map_entity_lang_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('blog_map_entity_lang', 'alias', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('blog_map_entity_lang', 'alias');
    }
}
