<?php

use yii\db\Migration;

/**
 * Handles adding status to table `blog_category`.
 */
class m171010_112121_add_status_column_to_blog_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
		$this->addColumn('blog_category', 'status_id', $this->integer());
		
		$comment = <<<EOT
1 - draft
7 - ready for publication, awaiting publisher confirmation
11 - published
13 - rejected by publisher			
17 - in trash
EOT;
		$this->addCommentOnColumn('blog_category', 'status_id', $comment);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
		$this->dropColumn('blog_category', 'status');
    }
}
