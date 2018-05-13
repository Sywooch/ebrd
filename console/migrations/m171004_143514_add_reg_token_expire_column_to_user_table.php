<?php

use yii\db\Migration;

/**
 * Handles adding reg_token_expire to table `user`.
 */
class m171004_143514_add_reg_token_expire_column_to_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'reg_token_expire', $this->timestamp()->defaultValue(NULL));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user', 'reg_token_expire');
    }
}
