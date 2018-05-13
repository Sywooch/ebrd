<?php

use yii\db\Migration;

/**
 * Handles adding pt to table `blog_map_entity_lang`.
 */
class m170922_082314_add_pt_column_to_blog_map_entity_lang_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('blog_map_entity_lang', 'pt', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('blog_map_entity_lang', 'pt');
    }
}
