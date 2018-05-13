<?php

use yii\db\Migration;

/**
 * Class m170921_120341_add_group_id_column_to_blog_category
 */
class m170921_120341_add_group_id_column_to_blog_category extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
		$this->addColumn('blog_category', 'group_id', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('blog_category', 'group_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170921_120341_add_group_id_column_to_blog_category cannot be reverted.\n";

        return false;
    }
    */
}
