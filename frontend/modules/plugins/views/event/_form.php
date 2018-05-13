<?php

use frontend\modules\plugins\models\App;
use frontend\modules\plugins\models\Plugin;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\plugins\widgets\Jsoneditor;
use frontend\modules\plugins\models\Category;

/**
 * @var $this yii\web\View
 * @var $model frontend\modules\plugins\models\Event
 * @var $form yii\widgets\ActiveForm
 */
$disabled = $model->plugin_id != Plugin::EVENTS_CORE;
?>

<div class="event-form">

    <?php $form = ActiveForm::begin(); ?>


        <div class="blog_post_col-1">
            <?= $form->field($model, 'trigger_class')->textInput(['disabled' => $disabled, 'maxlength' => true]) ?>
            <?= $form->field($model, 'trigger_event')->textInput(['disabled' => $disabled, 'maxlength' => true]) ?>
            <?= $form->field($model, 'handler_class')->textInput(['disabled' => $disabled, 'maxlength' => true]) ?>
            <?= $form->field($model, 'handler_method')->textInput(['disabled' => $disabled, 'maxlength' => true]) ?>
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


                    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->orderBy('name')->all(), 'id', 'name'), [
                        'prompt' =>  ' '
                    ]) ?>

            </div>

            <div class="blog_post_col-2">

                    <?= $form->field($model, 'status')->dropDownList([
                        $model::STATUS_INACTIVE => Yii::t('plugins', 'DISABLED'),
                        $model::STATUS_ACTIVE => Yii::t('plugins', 'ENABLED')
                    ]) ?>

                    <?= $form->field($model, 'pos')->textInput() ?>

            </div>
            <div class="blog_post_col_textarea">
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
