<?php

namespace frontend\modules\blog\controllers;

use yii\web\Controller;
use common\models\Profile;
use frontend\modules\blog\models\BlogHdbkEntity;
use frontend\modules\blog\models\BlogHdbkStatus;
use frontend\modules\blog\components\widgets\votes\model;
use Yii;

class CommonController extends Controller
{
        public function actionGetNews()
	{
            if (Yii::$app->request->isPost){
                return $this->renderAjax('_get-news');
            }
            return FALSE;
	}
    
	public function actionChangeStatus()
	{
		if (!empty(Yii::$app->request->post())){
			$post = Yii::$app->request->post();
			
			$entity = BlogHdbkEntity::findOne($post['entityTypeId']);
			
			$element = $entity->class_name::findOne($post['entityId']);
			$element->status_id = $post['statusId'];
			
			if ($element->save()){
				$res['status'] = '1';			
				if ($post['statusId'] == $element::STATUS_FOR_CONFIRMATION){
					$res['button'] = BlogHdbkStatus::getButtonToDraft($element);
				} elseif ( ($post['statusId'] == $element::STATUS_DRAFT)){
					$res['button'] = BlogHdbkStatus::getButtonForPublication($element);
				}
				$res['status'] = Yii::t('blog',
					'CURRENT STATUS OF THIS MATERIAL IS "{status}". TO CHANGE THE STATUS PRESS THE BUTTON BELOW',
					['status' => Yii::t('blog', $element->status->name)]);
				return $this->asJson($res);
			} else {
				$res['status'] = '0';
			}
		}
	}
	
	public function actionAddVote()
	{
		if (!empty(Yii::$app->request->post())){
			$ip = Yii::$app->request->getRemoteIP();
			$Id = Yii::$app->request->post('Id');
			$isBlogPost = Yii::$app->request->post('isBlogPost');
			if ($isBlogPost){
				$entity = model\Vote::findOne([
				'blog_post_id' => $Id,
				'ip' => $ip,
				]);
			}else{
				$entity = model\Vote::findOne([
				'category_id' => $Id,
				'ip' => $ip,
				]);	
			}

			if (is_null($entity)){
				$vote = new model\Vote();
				$vote->ip = $ip;
				if ($isBlogPost){
					$vote->blog_post_id = $Id;
				}else{
					$vote->category_id = $Id;
				}
				
				$vote->rating = Yii::$app->request->post('rating');
				$vote->save();
			} else return $this->asJson(['message' => 'Aleady voted']);
			
			if ($isBlogPost){
					$rating = \frontend\modules\blog\components\widgets\votes\Votes::getRates($Id,true)['rating'];
				} else {
					$rating = \frontend\modules\blog\components\widgets\votes\Votes::getRates($Id,false)['rating'];		
				}
				return $this->asJson(['rating' => $rating, 'message' => 'OK']);

		}
	}

	public function actionGetHooks()
	{
		if (Yii::$app->request->isPost){
			return $this->renderAjax('_get-hooks', ['hook' => Yii::$app->request->post()['hook']]);
		}
		return FALSE;
	}
	
	public function actionAddToSeoClub()
	{
		if(!empty(Yii::$app->user->id)) {
			if(Profile::sendSeoClubRequest()) {
				Yii::$app->session->setFlash('success', Yii::t('blog', 'YOUR_REQUEST_SENT'));
				return $this->goBack();
			}
			Yii::$app->session->setFlash('danger', Yii::t('blog', 'REQUEST_NOT_SENT_ERROR'));
			return $this->goBack();
		} else {
			$session = Yii::$app->session;
			$session->set('seoClubIngoing', true);
			return $this->redirect(['/site/signup']);
		}
	}
}
