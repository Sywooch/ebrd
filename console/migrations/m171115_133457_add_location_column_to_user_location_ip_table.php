<?php

use yii\db\Migration;

/**
 * Handles adding location to table `user_location_ip`.
 */
class m171115_133457_add_location_column_to_user_location_ip_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
		$this->addColumn('user_location_ip', 'location', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
		$this->dropColumn('user_location_ip', 'location', $this->string());
    }
}
