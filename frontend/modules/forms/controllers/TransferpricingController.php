<?php

namespace frontend\modules\forms\controllers;
use frontend\modules\forms\models\TransferPricing;
use Yii;

class TransferpricingController extends \yii\web\Controller
{
    public function actionIndex()
    {	
		$model = new TransferPricing;

		if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
			$model->saveAsJson(Yii::$app->request->post());
			
			return $this->redirect(['/thank-you']);
		}else{
			return $this->render('_form',[
				'model' => $model,
				'years' => ['2015','2016','2017','2018*'],
			]);
		}
    }
}
