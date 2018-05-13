<?php

use yii\db\Migration;

/**
 * Handles the creation of table `separate_phones_numbers`.
 */
class m171101_104220_create_separate_phones_numbers_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('separate_phones_numbers', [
            'id' => $this->primaryKey(),
			'country_id' => $this->string(),
            'phone_number' => $this->string(),
            'description' => $this->text(),
			'created_at' => 'TIMESTAMP NULL',
            'updated_at' => 'TIMESTAMP NULL',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('separate_phones_numbers');
    }
}
