<?php

namespace frontend\modules\plugins\components;

use Yii;

/**
 * Class FlashNotification
 * @package frontend\modules\plugins\components
 */
class FlashNotification
{
    /**
     * @param $message
     */
    public function success($message)
    {
        Yii::$app->session->setFlash('success', $message);
    }

    /**
     * @param $message
     */
    public function error($message)
    {
        Yii::$app->session->setFlash('error', $message);
    }
}