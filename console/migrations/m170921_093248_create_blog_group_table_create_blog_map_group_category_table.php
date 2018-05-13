<?php

use yii\db\Migration;

/**
 * Handles the creation of table `blog_group_table_create_blog_map_group_category`.
 */
class m170921_093248_create_blog_group_table_create_blog_map_group_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('blog_group', [
            'id' => $this->primaryKey(),
			'name' => $this->string(255)->notNull(),
			'lang_id' => $this->integer()->notNull(),
			'created_at' => $this->timestamp()->null(),
			'updated_at' => $this->timestamp()->null(),
        ]);
		
        $this->createTable('blog_map_group_category', [
            'group_id' => $this->integer(),
			'category_id' => $this->integer(),
			'PRIMARY KEY(group_id, category_id)',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('blog_group');
        $this->dropTable('blog_map_group_category');
    }
}
