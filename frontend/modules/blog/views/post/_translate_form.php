<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogPost */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-post-form blog-post-form-c-translate">

    <?php $form = ActiveForm::begin(); ?>
    <div class="blog_post_col-1">
    <?= $form->field($old_model, 'alias')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <?= $form->field($old_model, 'name')->textInput(['maxlength' => true, 'readonly' => true]) ?>
	
    <?= $form->field($old_model, 'title')->textInput(['maxlength' => true, 'readonly' => true]) ?>
        
    <?= $form->field($old_model, 'menu_section')->textInput(['maxlength' => true, 'readonly' => true]) ?>
    </div>
    <div class="blog_post_col-2">
    <?= $form->field($old_model, 'lang_id')->dropDownList($items,['disabled' => true]); ?>

    <?= $form->field($old_model, 'main_category_id')->dropDownList($parent,['disabled' => true]); ?>
        
    <?= $form->field($old_model, 'published_at')->textInput(['readonly' => true]) ?>
		
	<?= $form->field($old_model, 'author_id')->dropDownList($authors,['disabled' => true]); ?>
    </div>
    <div class="blog_post_col_textarea">
    <?= $form->field($old_model, 'description')->textarea(['rows' => 6, 'readonly' => true]) ?>
    </div>
    <div class="blog_post_col_textarea">
    <?= $form->field($old_model, 'excerpt')->textarea(['rows' => 6]) ?>
    </div>
    <div class="blog_post_col_editor">
	<?= $form->field($old_model, 'content')->widget(TinyMce::className(), [
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
	<div class="thumbnail_alt_conatiner_translate">
		<?= $form->field($old_model, 'thumb_alt')->textInput(['readonly' => true]) ?>
	</div>
    <?php if(!empty(Yii::$app->imagemanager->getImagePath($old_model->thumbnail))){ ?>
        <div class="image-manager-input">
            <div class="image-wrapper ">
                <img alt="Thumbnail" class="img-responsive img-preview" src="<?= Yii::$app->imagemanager->getImagePath($old_model->thumbnail); ?>">
            </div>
        </div>
    <?php } ?>
    <?php ActiveForm::end(); ?>

</div>


<div class="blog-post-form blog-post-form-c-translate">

	
	
    <?php $form = ActiveForm::begin(); ?>
	
	<?php
	if(!empty($translateRow)){
			echo Html::hiddenInput('BlogMapEntityLang[id]', $translateRow->id);
		}else{
			$translateRow->alias = '';
		}
	?>
    <div class="blog_post_col-1">
    <?= $form->field($model, 'alias')->textInput(['maxlength' => true, 'value' => $translateRow->alias, 'readonly' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        
    <?= $form->field($model, 'menu_section')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="blog_post_col-2">
    <?= $form->field($model, 'lang_id')->dropDownList($newLangCode);?>
		
	<?php
		if($catFlag){
			echo $form->field($model, 'main_category_id')->dropDownList($categoryList);
		}else{
			echo $form->field($model, 'main_category_id')->dropDownList($categoryList, ['prompt' => ' - '.Yii::t('blog', 'NO_TRANSLATION').' - ']);
		}
    ?>
        
    <?= $form->field($old_model, 'published_at')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Select issue date ...'],
                'pluginOptions' => [
                    'autoclose'=>true,
                    'todayHighlight' => true,
                    'format' => 'yyyy-mm-dd',
                ]
            ]); ?>
		
	<?= $form->field($old_model, 'author_id')->dropDownList($authors); ?>
    </div>
    <div class="blog_post_col_textarea">
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    </div>
    <div class="blog_post_col_textarea">
    <?= $form->field($model, 'excerpt')->textarea(['rows' => 6]) ?>
    </div>
    <div class="blog_post_col_editor">
	<?= $form->field($model, 'content' )->widget(TinyMce::className(), [
		'options' => ['rows' => 15,'id' => 'translation_editor'],
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
	<div class="thumbnail_alt_conatiner_translate">
		<?= $form->field($model, 'thumb_alt')->textInput() ?>
	</div>
    <div class="blog_post_col_thumbnail">
	<?=
        $form->field($old_model, 'thumbnail')->widget(\noam148\imagemanager\components\ImageManagerInputWidget::className(), [
                'aspectRatio' => (16/9),
                'cropViewMode' => 1,
                'showPreview' => true,
                'showDeletePickedImageConfirm' => false,
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
