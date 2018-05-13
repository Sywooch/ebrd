<?php

namespace frontend\modules\letter\controllers;

error_reporting(E_ALL);

use frontend\modules\blog\models\BlogMapEntityLang;
use Yii;
use frontend\modules\letter\models\Letter;
use frontend\modules\letter\models\LetterSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use frontend\models\HdbkLanguage;

/**
 * LetterController implements the CRUD actions for Letter model.
 */
class LetterController extends Controller
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
                        'actions' => [
                            'update',
                            'view'
                        ],
                        'roles' => ['editItem'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['createItem']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['deleteItem'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['translate', 'publishItem', 'editItem'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Letter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LetterSearch();
        $items = null;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Letter model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Letter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Letter();

        $languages = HdbkLanguage::getLanguagesSymbols();
        $items = ArrayHelper::map($languages,'id','name');
        $curr_lang = Letter::formatLangCode(Yii::$app->language, $languages);
        $items = $curr_lang + $items;

        $request = Yii::$app->request->get();
        $oldModel =  isset($request['translated_id']) ? Letter::findOne($request['translated_id']) : null;
        $translateLang = isset($request['translate_to']) ? Letter::formatLangCode($request['translate_to'], $languages) : null;
        $translateRow = $oldModel && $translateLang ? BlogMapEntityLang::getTranslationLetterRow($oldModel->id, $oldModel->lang->code) : null;
        $translate = isset($request['translate_to']) && !$translateRow[$request['translate_to']] && $oldModel && $translateLang;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'items' => $items,
                'currLang' => $translateLang,
                'translate' => $translate,
                'translateRow' => $translateRow,
                'oldModel' => $oldModel,
            ]);
        }
    }

    /**
     * Updates an existing Letter model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $languages = HdbkLanguage::getLanguagesSymbols();
        $currLang = Letter::formatLangCode($model->lang->code, $languages);
        $defaultLanguage = HdbkLanguage::getLanguageByCode($model->lang->code);
        $translateRow = BlogMapEntityLang::getTranslationLetterRow($id, $model->lang->code);
        $usedCodes = BlogMapEntityLang::getUsedCodes($translateRow);
        $items = HdbkLanguage::getOptionLanguages($languages, $defaultLanguage, $usedCodes) + $currLang;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'items' => $items,
                'translate' => false,
                'oldModel' => false,
                'translationBtns' => BlogMapEntityLang::getTranslationBtns($languages, $translateRow, $usedCodes),
                'translateRow' => $translateRow,
                'emptyColTranslationArray' => BlogMapEntityLang::getEmptyColTranslationArray($translateRow),
            ]);
        }
    }

    /**
     * Deletes an existing Letter model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Letter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Letter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Letter::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
