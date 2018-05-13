<?php

namespace frontend\modules\blog\controllers;

use common\models\User;
use frontend\models\HdbkLanguage;
use frontend\modules\blog\models\BlogEventStatus;
use frontend\modules\blog\models\BlogMapEventUser;
use frontend\modules\blog\models\BlogStakeholder;
use Yii;
use frontend\modules\blog\models\BlogEvent;
use frontend\modules\blog\models\BlogEventSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\letter\models\Letter;

/**
 * EventController implements the CRUD actions for BlogEvent model.
 */
class EventController extends Controller
{
    /**
     * @inheritdoc
     */
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
                        'actions' => ['front-view'],
                        'roles' => ['@', '?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index']
//                        'roles' => ['editItem', 'translate', 'publishItem'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create']
//                        'roles' => ['editItem', 'translate', 'publishItem'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update']
//                        'roles' => ['editItem', 'translate', 'publishItem'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view']
//                        'roles' => ['editItem', 'translate', 'publishItem'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['bind']
//                        'roles' => ['editItem', 'translate', 'publishItem'],
                    ],

                ]
            ]
        ];
    }

    /**
     * Lists all BlogEvent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BlogEventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all BlogEvent models.
     * @return mixed
     */
    public function actionBind($eventId)
    {
        if (!Yii::$app->user->isGuest){
            $user = Yii::$app->user->identity;
            $model = $this->findModel($eventId);
            if (!$this->isUserEventSubscribe($user->id, $model)){
                $mapEventUser = new BlogMapEventUser();
                $mapEventUser->user_id = $user->id;
                $mapEventUser->event_id = $model->id;
                $mapEventUser->status = 2; //Confirmed
                $mapEventUser->save();
                self::sendConfirmationEmail($user, $model);
                return $this->asJson(['message' => Yii::t('blog', 'EVENT_ADDED_TO_USER')]);
            }
            return $this->asJson(['message' => Yii::t('blog', 'EVENT_ALREADY_ADDED_TO_USER')]);
        }
        return $this->asJson(['message' => Yii::t('blog', 'PLEASE_LOGIN')]);
    }

    /**
     * Sends email to user for event notification
     *
     * @param User
     * @return bool
     */
    private static function sendConfirmationEmail($user,$event)
    {
        $languages = ArrayHelper::map(HdbkLanguage::getLanguagesSymbols(), 'code', 'id');
        $language = \Yii::$app->language;
        $langId = $languages[$language];
        $model = Letter::find()->where(['name' => 'event_notification', 'lang_id' => $langId])->one() ??
            Letter::find()->where(['name' => 'event_notification', 'lang_id' => $languages['en']])->one();
        $message = self::composeNotificationEmail($model->content, $event->title);
        $subject = $model->title;

        return \Yii::$app->mailer->compose()
            ->setFrom([\Yii::$app->params['adminEmail'] => Yii::$app->name])
            ->setTo($user->email)
            ->setHtmlBody($message)
            ->setSubject($subject)
            ->send();
    }

    private static function composeNotificationEmail($content, $event)
    {
        $content = preg_replace("/{{event}}/ui", $event, $content);
        if(\Yii::$app->language == 'uk'){
            $content .= \Yii::$app->params['settings']['sing_uk'];
        }else{
            $content .= \Yii::$app->params['settings']['sing_en'];
        }
        return $content;
    }



    /**
     * Displays a single BlogEvent model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Displays a single BlogPost model in user's frontend.
     * @param integer $id
     * @return mixed
     */
    public function actionFrontView($id)
    {
        Yii::$app->cache->flush();
        $user = Yii::$app->user->identity;
        $this->layout = '/../../views/layouts/fullscreen.php';

        $event = $this->findModel($id);
        $subscription = $this->isUserEventSubscribe($user->id,$event);
            return $this->render('front-view', [
                'model' => $event,
                'subscription' => $subscription
            ]);
    }

    private function isUserEventSubscribe($user_id,$event){
        if (!Yii::$app->user->isGuest) {
            if (empty($event->getUsers()->where(['id' => $user_id])->all())){
                return false;
            } else {
                return true;
            }
        }
        return null;
    }


    /**
     * Creates a new BlogEvent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BlogEvent();
        $languages = ArrayHelper::map(HdbkLanguage::getLanguagesSymbols(),'id','name');
        $stakeholders = ArrayHelper::map(
            BlogStakeholder::find()->asArray()->all() ,'id','name'
        );
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'languages' => $languages,
            'stakeholders' => $stakeholders
        ]);
    }

    /**
     * Updates an existing BlogEvent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $languages = ArrayHelper::map(HdbkLanguage::getLanguagesSymbols(),'id','name');
        $stakeholders = ArrayHelper::map(
            BlogStakeholder::find()->asArray()->all() ,'id','name'
        );
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'languages' => $languages,
            'stakeholders' => $stakeholders
        ]);
    }

    /**
     * Deletes an existing BlogEvent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BlogEvent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BlogEvent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BlogEvent::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }




    public function beforeAction($action)
    {
        $publicActions = [
            'front-view',
        ];

        if (!in_array($action->id, $publicActions)){
            $this->layout = '/../../views/layouts/administrator.php';
        }

        if (!parent::beforeAction($action)) {
            return false;
        }

        // other custom code here

        return true; // or false to not run the action
    }
}
