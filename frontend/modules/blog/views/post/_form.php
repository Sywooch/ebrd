<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogPost */
/* @var $form yii\widgets\ActiveForm */

?>


<div class="blog-post-form">

    <?php $form = ActiveForm::begin();  ?>
	
	<?php
            if(!empty($translateRow)){
                    echo Html::hiddenInput('BlogMapEntityLang[id]', $translateRow->id);
            }
	?>
	<div class="blog_post_col-1">
	<div id="name">
	<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	</div>
	
        <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
	
	<div id="page">
		<?= $form->field($model, 'title')->textInput() ?>
	</div>
	<div id="item">
	<?= $form->field($model, 'menu_section')->textInput() ?>
	</div>
	<?= $form->field($model, 'time_to_read')->textInput(['type' => 'number']) ?>
    </div>
    <div class="blog_post_col-2">
    <?= $form->field($model, 'lang_id')->dropDownList($items,
            ['onchange'=>'
                $.post( "'.Yii::$app->urlManager->createUrl('/blog/category/list-by-lang?id=').'"+$(this).val(), function( data ) {
                  $( "select#blogpost-main_category_id" ).html( data );
                });
            ']); ?>
		
    <?= $form->field($model, 'main_category_id')->dropDownList($parent); ?>
		
	<?= $form->field($model, 'published_at')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Select issue date ...'],
                'pluginOptions' => [
                    'autoclose'=>true,
                    'todayHighlight' => true,
                    'format' => 'yyyy-mm-dd',
                ]
            ]); ?>
		
	<?= $form->field($model, 'author_id')->dropDownList($authors); ?>
		
	<?= $form->field($model, 'show_author')->checkbox(); ?>
    </div>
    <div class="blog_post_col_textarea">
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    </div>
    <div class="blog_post_col_textarea">
    <?= $form->field($model, 'excerpt')->textarea(['rows' => 6]) ?>
    </div>
    <div class="blog_post_col_editor">

    <?= $form->field($model, 'content')->widget(TinyMce::className(), [
		'options' => ['rows' => 15],
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
	<div class="thumbnail_alt_conatiner">
		<?= $form->field($model, 'thumb_alt')->textInput() ?>
	</div>
    <div class="blog_post_col_thumbnail">
	<?=
		$form->field($model, 'thumbnail')->widget(\noam148\imagemanager\components\ImageManagerInputWidget::className(), [
			'aspectRatio' => (16/9), //set the aspect ratio
			'cropViewMode' => 1, //crop mode, option info: https://github.com/fengyuanchen/cropper/#viewmode
			'showPreview' => true, //false to hide the preview
			'showDeletePickedImageConfirm' => false, //on true show warning before detach image
		]);
	?>
    </div>
    <div class="blog_post_col_submit">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('blog', 'CREATE') : Yii::t('blog', 'UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
