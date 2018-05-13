<?php

namespace frontend\components\traits;

use Yii;

trait FilterTrait
{
    /**
     * Save filter into session
     * @param $target
     * @param $params
     * @return mixed
     */
    public function saveFilter($target, $params)
    {
        if (!empty($params)) {
            Yii::$app->session[$target . 'SearchParams'] = Yii::$app->request->queryParams;
        }

        if (isset(Yii::$app->session[$target . 'SearchParams'])) {
            return Yii::$app->session[$target . 'SearchParams'];
        } else {
            return $params;
        }
    }

    /**
     * Clear filter data
     * @return \yii\web\Response
     */
    public function actionResetFilter($target)
    {
        unset(Yii::$app->session[$target . 'SearchParams']);
        return $this->redirect(['index']);
    }
}