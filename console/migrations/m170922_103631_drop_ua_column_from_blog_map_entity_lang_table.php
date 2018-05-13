<?php

use yii\db\Migration;

/**
 * Handles dropping ua from table `blog_map_entity_lang`.
 */
class m170922_103631_drop_ua_column_from_blog_map_entity_lang_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('blog_map_entity_lang', 'ua');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('blog_map_entity_lang', 'ua', $this->integer());
    }
}
