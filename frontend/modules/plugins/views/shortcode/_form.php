<?php

use frontend\modules\plugins\models\App;
use frontend\modules\plugins\widgets\Jsoneditor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model frontend\modules\plugins\models\Shortcode
 * @var $form yii\widgets\ActiveForm
 */
$disabled = true;
?>

<div class="event-form">

    <?php $form = ActiveForm::begin(); ?>

        <div class="blog_post_col-1">
            <?= $form->field($model, 'handler_class')->textInput(['disabled' => $disabled, 'maxlength' => true]) ?>
            <?= $form->field($model, 'tag')->textInput(['disabled' => $disabled, 'maxlength' => true]) ?>
            <?= $form->field($model, 'tooltip')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="blog_post_col-2">
            <?= $form->field($model, 'data')->widget(Jsoneditor::class,
                [
                    'editorOptions' => [
                        'modes' => ['code', 'form', 'text', 'tree', 'view'], // available modes
                        'mode' => 'form', // current mode
                    ],
                    'options' => ['style' => 'height:225px'], // html options
                ]
            ); ?>
        </div>
        <div class="blog_post_col-3">
                <div class="blog_post_col-1">
                    <?= $form->field($model, 'app_id')->dropDownList(ArrayHelper::map(App::find()->all(), 'id', 'name')) ?>

                        <?= $form->field($model, 'status')->dropDownList([
                            $model::STATUS_INACTIVE => Yii::t('plugins', 'DISABLED'),
                            $model::STATUS_ACTIVE => Yii::t('plugins', 'ENABLED')
                        ]) ?>
                </div>
            <div class="blog_post_col-2">
            <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(frontend\modules\plugins\models\Category::find()->orderBy('name')->all(), 'id', 'name'), [
                'prompt' => ' '
            ]) ?>
            <?= $form->field($model, 'text')->textarea() ?>
            </div>
        </div>


    <div class="blog_post_col_submit">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('plugins', 'CREATE') : Yii::t('plugins', 'UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
