<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `url_post_drop_rul_cat`.
 */
class m170918_074655_drop_url_post_drop_rul_cat_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropTable('url_post');
        $this->dropTable('url_cat');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->createTable('url_post', [
            'id' => $this->primaryKey(),
        ]);
        $this->createTable('url_cat', [
            'id' => $this->primaryKey(),
        ]);
    }
}
