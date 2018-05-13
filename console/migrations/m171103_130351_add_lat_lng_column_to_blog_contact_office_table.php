<?php

use yii\db\Migration;

/**
 * Handles adding lat_lng to table `blog_contact_office`.
 */
class m171103_130351_add_lat_lng_column_to_blog_contact_office_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('blog_contact_office', 'lat', $this->float());
		$this->addColumn('blog_contact_office', 'lng', $this->float());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
		$this->dropColumn('blog_contact_office', 'lat', $this->float());
		$this->dropColumn('blog_contact_office', 'lng', $this->float());
    }
}
