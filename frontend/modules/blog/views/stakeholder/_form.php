<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\modules\blog\models\BlogCategory;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogStakeholder */
/* @var $form yii\widgets\ActiveForm */
$lang = Yii::$app->language;
?>

<div class="blog-stakeholder-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mail')->Input('email', ['maxlength' => true, 'hint' => 'Input email']) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?php
		if($lang == 'en') {
			echo $form->field($model, 'group_id')->dropDownList(ArrayHelper::map(BlogCategory::find()->where(['parent_category_id' => BlogCategory::find()->select('id')->where('name like "%Stakeholders%"')->one()])->asArray()->all(), 'id', 'name'), ['prompt' => 'select group']);
		} else if($lang == 'uk') {
			echo $form->field($model, 'group_id')->dropDownList(ArrayHelper::map(BlogCategory::find()->where(['parent_category_id' => BlogCategory::find()->select('id')->where('name like "%Зацікавлені сторони%"')->one()])->asArray()->all(), 'id', 'name'), ['prompt' => 'select group']);
		}
	?>		

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>
	
	<?php echo $form->field($model, 'logo')->widget(FileInput::classname(), [
			'options' => ['accept' => 'image/*'],
            'pluginOptions' => [
                    'allowedFileExtensions' => ['jpg', 'gif', 'png'],
                    'previewFileType' => 'image',
                    'showPreview' => false,
                    'showCaption' => false,
                    'showRemove' => false,
                    'showUpload' => false,
                    'browseClass' => 'btn',
                    'browseIcon' => '',
                    'browseLabel' =>  '<img id="stakeholder-img" src="'.($model->logo?'/images/stakeholders_logo/'.$model->logo:'/images/avatars/def_avatar.png').'" class="img img-responsive">',
                    'initialPreview'=> $model->logo ? [
                        '<img src="/images/stakeholders_logo/'.$model->logo.'" class="img img-responsive">',
                    ] : false,
				]
			])?>
	<div><span><?= Yii::t('blog', 'STAKEHOLDERS_FILE_RECOMENDATION_RESOLUTION')?></span></div>
    <?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$current_language = Yii::$app->language;
$this->registerJsFile(
    "https://maps.googleapis.com/maps/api/js?key=AIzaSyCk1xu86PPDY4gzg7tYfRvfOfqt5bQR8fk&libraries=places&callback=initAutocomplete&language={$current_language}",
    ['position' => $this::POS_END, 'async'=>true, 'defer'=>true]);
?>

<?php

$js = <<<JS
$('#blogstakeholder-logo').change(function () {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#stakeholder-img').attr('src', e.target.result);
        };
        reader.readAsDataURL(this.files[0]);
    }
});
JS;
$this->registerJs($js);
?>