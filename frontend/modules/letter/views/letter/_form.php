<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model frontend\modules\letter\models\Letter */
/* @var $form yii\widgets\ActiveForm */
/* @var $items */
/* @var $translate */
/* @var $currLang */
/* @var $oldModel */

?>

<div class="letter-form <?= $translate ? "blog-post-form-c-translate" : null ?>">

    <?php $form = ActiveForm::begin(); ?>

    <div class="blog_post_col-1">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'disabled' => $disabled, 'value' => $oldModel->name ?? null]) ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'disabled' => $disabled]) ?>

        <?= $form->field($model, 'keywords')->textInput(['maxlength' => true, 'disabled' => $disabled, 'value' => $oldModel->keywords ?? null]) ?>

        <?= $form->field($model, 'lang_id')->dropDownList($items, ['disabled' => $disabled]) ?>
    </div>

    <div class="blog_post_col_editor">
        <?= $form->field($model, 'content')->widget(TinyMce::className(), [
            'options' => ['rows' => 15, 'id' => ($disabled ? 1 : 2)],
            'language' => Yii::$app->language,
            'clientOptions' => [
                'relative_urls' => false,
                'file_browser_callback' => new yii\web\JsExpression("function(field_name, url, type, win) {
				window.open('".yii\helpers\Url::to(['/imagemanager/manager', 'view-mode'=>'iframe', 'select-type'=>'tinymce'])."&tag_name='+field_name,'','width=800,height=540 ,toolbar=no,status=no,menubar=no,scrollbars=no,resizable=no');
			}"),
                'plugins' => [
                    "advlist autolink lists link image charmap preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table contextmenu directionality"
                ],
                'toolbar1' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | link | image | fullscreen | code | preview"
            ]
        ]);?>
    </div>

    <?php if (!$disabled) : ?>
    <div class="blog_post_col_submit">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php endif; ?>

    <?php ActiveForm::end(); ?>

</div>