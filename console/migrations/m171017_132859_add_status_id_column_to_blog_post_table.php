<?php

use yii\db\Migration;

/**
 * Handles adding status to table `blog_category`.
 */
class m171017_132859_add_status_id_column_to_blog_post_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
		$this->addColumn('blog_post', 'status_id', $this->integer()->defaultValue(1));
		
		$comment = <<<EOT
1 - draft
7 - ready for publication, awaiting publisher confirmation
11 - published
13 - rejected by publisher			
17 - in trash
EOT;
		$this->addCommentOnColumn('blog_post', 'status_id', $comment);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
		$this->dropColumn('blog_post', 'status_id');
    }
}
