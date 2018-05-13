<?php

namespace frontend\modules\forms\controllers;
use frontend\modules\forms\models\Inquirer1;
use Yii;

class InquirerController extends \yii\web\Controller
{
    public function actionIndex()
    {	
        return $this->render('index');
    }
	
	public function actionTestLocal()
    {	
		$model = new Inquirer1;
		
		if($model->load(Yii::$app->request->post())){
			echo '<pre>';
			var_dump(Yii::$app->request->post());
			echo '</pre>';
			die();
		}
		
        return $this->render('test-local',[
			'model' => $model,
		]);
    }
	
	public function actionTest()
    {
		return $this->render('test');
    }
	
	public function beforeAction($action)
	{
		$this->layout = '/../../views/layouts/administrator.php';

		if (!parent::beforeAction($action)) {
			return false;
		}

		return true;
	}

}
