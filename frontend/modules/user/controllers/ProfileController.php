<?php

namespace frontend\modules\user\controllers;

use frontend\modules\user\models\Profile;
use common\models\AuthAssignment;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

/**
 * Description of ProfileController
 *
 * @author petrovich
 */
class ProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'settings',
                            'index',
                        ],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex($id = false)
    {
		$userId = $id ? $id : Yii::$app->user->id;
        $model = Profile::find()->where(['user_id' => $userId])->one();


        return $this->render('index', [
            'model' => $model
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionSettings($id = false)
    {

		$userId = $id ? $id : Yii::$app->user->id;
	
        $model = Profile::find()->where(['user_id' => $userId])->one();
        if ($model->load(Yii::$app->request->post()) && $model->updateSettings()) {
            Yii::$app->session->setFlash('success', Yii::t('user', 'INFORMATION_UPDATED'));
			if($userId === Yii::$app->user->id){
				return $this->redirect(['/user/profile']);
			}else{
				return $this->redirect(['/user/default']);
			}
        }

        return $this->render('settings', [
            'model' => $model,
        ]);
    }
	
	
	public function beforeAction($action)
	{
		$this->layout = '/../../views/layouts/administrator.php';

		if (!parent::beforeAction($action)) {
			return false;
		}

		// other custom code here

		return true; // or false to not run the action
	}
}
