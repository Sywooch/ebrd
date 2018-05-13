<?php

use yii\db\Migration;

/**
 * Handles adding ua to table `blog_map_entity_lang`.
 */
class m171003_115831_add_ua_column_to_blog_map_entity_lang_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('blog_map_entity_lang', 'ua', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('blog_map_entity_lang', 'ua');
    }
}
