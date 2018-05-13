<?php

use yii\db\Migration;

/**
 * Handles adding status to table `blog_group`.
 */
class m171018_084710_add_status_id_in_blog_category extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
		$this->addColumn('blog_group', 'status_id', $this->integer()->defaultValue(1));
		
		$comment = <<<EOT
1 - draft
7 - ready for publication, awaiting publisher confirmation
11 - published
13 - rejected by publisher			
17 - in trash
EOT;
		$this->addCommentOnColumn('blog_group', 'status_id', $comment);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
		$this->dropColumn('blog_group', 'status_id');
    }
}
