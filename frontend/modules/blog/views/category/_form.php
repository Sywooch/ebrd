<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use kartik\select2\Select2;
use frontend\components\widgets\id_category\PostsInCategory;
use yii\helpers\ArrayHelper;
use frontend\modules\blog\models\BlogPost;
/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-category-form">
    <?php $form = ActiveForm::begin(); ?>

	<?php
		if(!empty($translateRow)){
			echo Html::hiddenInput('BlogMapEntityLang[id]', $translateRow->id);
		}
	?>
    <div class="blog_post_col-1">
	<?= $form->field($model, 'lang_id')->dropDownList($items,
            ['onchange'=>'
                $.post( "'.Yii::$app->urlManager->createUrl('/blog/category/list-by-lang?id=').'"+$(this).val(), function( data ) {
                  $( "select#blogcategory-parent_category_id" ).html( data );
                });
                $.post( "'.Yii::$app->urlManager->createUrl('/blog/category/group-by-lang?id=').'"+$(this).val(), function( data ) {
                  $( "select#blogcategory-group_id" ).html( data );
                });
            ']); ?>

    <?= $form->field($model, 'parent_category_id')->dropDownList($parent); ?>

    <?= $form->field($model, 'group_id')->dropDownList($groups,['prompt' => ' - '.Yii::t('blog', 'SELECT_GROUP').' - ']); ?>

	<?= $form->field($model, 'layout_id')->dropDownList($layouts,['prompt' => Yii::t('blog', 'DEFAULT_LAYOUT')]); ?>
    </div>
    <div class="blog_post_col-2">
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
    </div>
    <div class="blog_post_col_textarea">
	<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
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
	<div class="admin-shortcodes">
	<?php
		if(!$model->isNewRecord) {
			if(!empty($model->shortcodes)) {
				$hookids = $model->getPostsID($model->shortcodes);
				$dataProvider = ArrayHelper::map(BlogPost::find()->where(['not', ['id' => $hookids]])->all(), 'id', 'name');
			} else if($model->getHookFromContent()) {
				$hookids = $model->getPostsID($model->getHookFromContent());
				$dataProvider = ArrayHelper::map(BlogPost::find()->where(['not', ['id' => $hookids]])->all(), 'id', 'name');
			}
			else {
				$dataProvider = ArrayHelper::map(BlogPost::find()->all(), 'id', 'name');
			}
			echo $form->field($model, 'postsearch')->widget(Select2::classname(), [
				'data' => $dataProvider,
				'options' => [
					'placeholder' => 'Select a post ...',
					'class' => 'sooqa',
				],
			]); 
			echo Html::submitButton(Yii::t('blog', 'POST_ADD'), ['class' => 'btn btn-primary admin-shortcodes__button']);
		}
	?>
	</div>
	<div class="blog_post_col_textarea">
	<?= PostsInCategory::widget(['content' => $model->content, 'categoryID' => $model->id]); ?>
	</div>

	<div class="blog_post_col_thumbnail">
	<?= $form->field($model, 'last_news')->checkbox() ?>
	<div class="thumbnail_alt_conatiner">
		<?= $form->field($model, 'thumbnail_alt')->textInput() ?>
	</div>

	<?=
        $form->field($model, 'thumbnail')->widget(\noam148\imagemanager\components\ImageManagerInputWidget::className(), [
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

<?php

$js = <<<JS

$('.sooqa').change(function(){
	$('.admin-shortcodes__button').css("display", "inline-block");
});

JS;

$this->registerJs($js);
?>
