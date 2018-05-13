<?php

namespace frontend\modules\forms\controllers;

use yii\web\Controller;
use Yii;

/**
 * Default controller for the `forms` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionForm()
    {
            if (Yii::$app->request->isGet){
                    $get = Yii::$app->request->get();
                    if (!empty($get['formId'])){
                            $params['formId'] = $get['formId'];
                    } elseif (!empty($get['chainId'])){
                            $params['chainId'] = $get['chainId'];
                    }
                    return $this->renderAjax('_form', ['params' => $params]);

            } elseif (Yii::$app->request->isPost){
                    $request = Yii::$app->request->post();
                    $model = \frontend\modules\forms\models\FormSubmit::findOne($request['DynamicModel']['formTemplateId']);
                    $result = $model->processForm($request['DynamicModel']);
                    if (empty($model->formFields)){
                            return $this->asJson($result);
                    } else {
                            return $this->renderAjax('_form', ['params' => $result]);
                    }

            }
    }
}
