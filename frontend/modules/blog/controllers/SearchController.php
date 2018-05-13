<?php

namespace frontend\modules\blog\controllers;

use yii\web\Controller;
use Yii;
use frontend\modules\blog\models\SearchForm;
use yii\data\ActiveDataProvider;

/**
 * Default controller for the `blog` module
 */
class SearchController extends Controller
{
	public function actionSearch() 
	{
		$queryModel = new SearchForm();
		
		$get = Yii::$app->request->get();
		$q = $get['SearchForm']['q'];

		if($q == null || $q == '') {
			return $this->redirect(['/']);
		}
		
		$paramsName = ['like', 'name', $q];
		$paramsContent = ['like', 'content', $q];
		
		$queryName = $queryModel::searchData($paramsName, $paramsContent);

		$dataProvider = new ActiveDataProvider([
			'query' => $queryName,
			'pagination' => [
				'pageSize' => 5,
			],
		]);
		
		return $this->render('index', [
			'listDataProvider' => $dataProvider,
			'q' => $q,
		]);
	}
	
	
	// delete later begin
	
	public function actionDevTest()
	{
		return $this->render('dev-test');
	}
	
	public function actionAnalitika()
	{
		$this->layout = '/../../views/layouts/fullscreen.php';
		
		return $this->render('analitika');
	}
	
	public function actionTestYandex()
	{
		return $this->render('test-yandex');
	}
	
	// delete later end
}
