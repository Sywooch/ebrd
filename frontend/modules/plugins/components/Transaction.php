<?php

namespace frontend\modules\plugins\components;

use Yii;

/**
 * Class Transaction
 * @package frontend\modules\plugins\components
 */
class Transaction
{
    /**
     * @return \yii\db\Transaction
     */
    public function begin()
    {
        return Yii::$app->db->beginTransaction();
    }

    /**
     * @param \yii\db\Transaction $transaction
     */
    public function commit($transaction)
    {
        $transaction->commit();
    }

    /**
     * @param \yii\db\Transaction $transaction
     */
    public function rollBack($transaction)
    {
        $transaction->rollBack();
    }
}