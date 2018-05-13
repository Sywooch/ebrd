<?php

use yii\db\Migration;

class m170915_065253_add_iso_comment extends Migration
{
    public function safeUp()
    {
		$comment = <<<EOT
two symbol language code according to ISO 639-2
https://en.wikipedia.org/wiki/List_of_ISO_639-2_codes
EOT;
		$this->addCommentOnColumn('hdbk_language', 'code', $comment);
    }

    public function safeDown()
    {
		$this->dropCommentFromColumn('hdbk_language', 'code');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170915_065253_add_iso_comment cannot be reverted.\n";

        return false;
    }
    */
}
