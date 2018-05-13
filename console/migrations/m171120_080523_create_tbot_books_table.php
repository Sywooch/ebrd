<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tbot_books`.
 */
class m171120_080523_create_tbot_books_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('tbot_books', [
            'id' => $this->primaryKey(),
			'book_name' => $this->string(),
			'book_path' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('tbot_books');
    }
}
