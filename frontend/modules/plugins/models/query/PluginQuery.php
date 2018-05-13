<?php

namespace frontend\modules\plugins\models\query;

use frontend\modules\plugins\models\Plugin;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Plugin]].
 * @see Plugin
 */
class PluginQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return Plugin[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Plugin|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}