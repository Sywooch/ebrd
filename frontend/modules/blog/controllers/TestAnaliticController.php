<?php
namespace frontend\modules\blog\controllers;

use Yii;
use yii\web\Controller;
use frontend\modules\blog\models\TestAnaliticsMind;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TestAnaliticController extends Controller
{
	
	public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
			],
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'actions' => ['test','view-result','test-result'],
						'roles' => ['@'],
					],
					[
						'allow' => true,
						'actions' => ['admin-view-result'],
						'roles' => ['@','editItem'],
					],
				],
			],
        ];
    }

    /**
     * Lists all BlogPost models.
     * @return mixed
     */
    public function actionTest()
    {
		Yii::$app->cache->flush();
		
		$this->layout = '/../../views/layouts/fullscreen.php';
		
		$model = new TestAnaliticsMind();

		if ($model->find()->where(['user_id' => Yii::$app->user->id])->exists() && !Yii::$app->user->can('editItem')) {
			return $this->redirect('view-result');
		}
		if (!empty(Yii::$app->request->post())) {
			$answers = Yii::$app->request->post();
			$userid = Yii::$app->user->id;
			if($model->find()->where(['user_id' => Yii::$app->user->id])->exists() && Yii::$app->user->can('editItem'))
			{
				$model->findOne(['user_id' => $userid])->delete();
			}
			$model->saveTestResult($userid, $answers);
			return $this->redirect('test-result');
		}
        
		return $this->render('test', [
			'model' => $model
		]);
    }
	
	public function actionTestResult($userid = null)
    {
		Yii::$app->cache->flush();
		
		$this->layout = '/../../views/layouts/fullscreen.php';
		
		$model = new TestAnaliticsMind();
		if (!empty($userid)) {
			$model = TestAnaliticsMind::find()
				->where(['user_id' => $userid])
				->one();
			return $this->render('test-result', [
				'model' => $model
			]);
		} else {
			if ($model->find()->where(['user_id' => Yii::$app->user->id])->exists()) {
				$model = TestAnaliticsMind::find()
					->where(['user_id' => Yii::$app->user->id])
					->one();
				return $this->render('test-result', [
					'model' => $model
				]);
			} else {
				return $this->redirect('test');
			}
		}
		
    }
	
	public function actionViewResult($userid = NULL)
    {
		Yii::$app->cache->flush();
		
		$this->layout = '/../../views/layouts/administrator.php';
		if(!TestAnaliticsMind::find()->where(['user_id' => Yii::$app->user->id])->exists()) {
			return $this->redirect('test');
		}
		if (!empty($userid)) {
			$model = TestAnaliticsMind::find()
				->where(['user_id' => $userid])->one();
		} else {
			$model = TestAnaliticsMind::find()
				->where(['user_id' => Yii::$app->user->id])->one();
		}
		return $this->render('view-result', ['model' => $model]);
    }
	
	public function actionAdminViewResult()
	{
		Yii::$app->cache->flush();
		
		if(Yii::$app->user->can('editItem')) {
			$this->layout = '/../../views/layouts/administrator.php';
			$dataProvider = new ActiveDataProvider([
				'query' => TestAnaliticsMind::find(),
				'pagination' => false,
			]);
			return $this->render('admin-view-result', ['dataProvider' => $dataProvider]);
		} else {
			return $this->redirect('view-result');
		}
	}
}