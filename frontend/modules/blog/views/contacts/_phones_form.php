<?php
 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use frontend\modules\plugins\models\PluginsCountryLocationCode;
 
/* @var $this yii\web\View */
/* @var $model app\modules\notes\models\Notes */
/* @var $form yii\widgets\ActiveForm */
?>
 
<?php
    $this->registerJs(
        '$("document").ready(function(){
            $(".add").on("pjax:end", function() {
            $.pjax.reload({container:"#add-container"});  
        });
    });'
    );
?>
 
<div class="add">
<?php yii\widgets\Pjax::begin(['class' => '123add']) ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>
    <div class="blog_post_col-1">
	<?= $form->field($model, 'country_id')->dropDownList(ArrayHelper::map(
			PluginsCountryLocationCode::find()->with('countrycode')->all(), 'cc_iso', function($items) {
			return $items->country_name;
		}));	
	?>
		
		
    </div>
	<div class="blog_post_col-2">
		<?= $form->field($model, 'phone_number') ?>	
    </div>
	<div class="blog_post_col_textarea">
		<?= $form->field($model, 'description') ?>
	</div>	
	<div class="blog_post_col_submit">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('blog', 'CREATE') : Yii::t('blog', 'UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    </div>
    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
 
</div>