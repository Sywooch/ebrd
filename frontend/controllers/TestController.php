<?php

namespace frontend\controllers;

use frontend\modules\forms\models\Form;
use yii\filters\AccessControl;
use Yii;
use yii\helpers\Url;

/*
 * some examples for RBAC
 * 
 * more information here:
 * http://www.yiiframework.com/doc-2.0/guide-security-authorization.html#rbac
 */
class TestController extends \yii\web\Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'actions' => ['delete'],
						'roles' => ['deleteItem'],
					],
					[
						'allow' => true,
						'actions' => ['view'],
						'roles' => ['viewItem'],
					],
					[
						'allow' => true,
						'actions' => ['translate'],
						'roles' => ['translator'],
					],
					[
						'allow' => true,
						'actions' => ['edit'],
						'roles' => ['editItem'],
					],
					[
						'allow' => true,
						'actions' => ['delete'],
						'roles' => ['admin'],
					],
					[
						'allow' => true,
						'actions' => ['index'],
						'roles' => ['@'],
					],
				],
			],
		];
	}
    public function actionDelete()
    {
        return $this->render('delete');
    }

    public function actionEdit()
    {
        return $this->render('edit');
    }

    public function actionIndex()
    {
		return $this->render('index');
		return \yii\helpers\Json::encode([
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, doc, docx, pdf', 'maxSize' => 10*1024*1024],
			[['full_name', 'email', 'phone', 'position'], 'required'],
			[['full_name', 'phone', 'position'], 'string', 'max' => 45],
			[['message'], 'string', 'max' => 500],
			[['email'], 'email'],
        ]);
		
		$form = Form::findOne(2);
		$rules = [
			[['email'], 'required'],
			[['email'], 'email'],
		];
		$fields = [
			[
				'name' => 'email',
				'type' => 'textInput',
				'label' => FALSE,
				'options' => [
					'placeholder' => 'ENTER_YOUR_EMAIL_ADDRESS'
				]
			]
		];
		$submit = [
			'label' => 'SIGN_UP',
			'class' => 'subscrBtn'
		];
		$form->name = 'subscribeNews';
		$form->title = 'SUBSCRIPTION';
		$form->description = 'RECEIVE_OUR_NEWSLETTERS';
		$form->answer = 'SUBSCRIBED_SUCCESSFULLY';
		$form->mail_to = '';
		$form->fields = \yii\helpers\Json::encode($fields);
		$form->rules = \yii\helpers\Json::encode($rules);
		$form->submit = \yii\helpers\Json::encode($submit);
		$form->class = 'dynSub';
		$form->form_id = 'dynFormSubId';
		$form->save();
		echo '<pre>';
		\yii\helpers\VarDumper::dump($form);
		echo '</pre>';
		die();



		return $this->render('index', ['model' => $model]);
    }

    public function actionTranslate()
    {
        return $this->render('translate');
    }

    public function actionView()
    {
        return $this->render('view');
    }
    
//    public function beforeAction($action)
//    {
//        $toRedir = [
//            'index' => 'view',
//            'view' => 'edit',
//        ];
//
//        if (isset($toRedir[$action->id])) {
//            Yii::$app->response->redirect(Url::to([$toRedir[$action->id]]), 302);
//            Yii::$app->end();
//        }
//        return parent::beforeAction($action);
//    }

}
