<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $form yii\widgets\ActiveForm */
/* @var $this yii\web\View */
/* @var $model frontend\modules\translation\models\SourceMessage */

$this->title = 'Update constant: ' . $model->message;
$this->params['breadcrumbs'][] = ['label' => Yii::t('translation', 'TRANSLATIONS_MANAGER'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->message, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="add_trans_wrap">
	<h1><?= Yii::t('translation', 'UPDATE_TRANSLATION') ?></h1>
	
	<?php $form = ActiveForm::begin([
		'options' => ['id' => 'trans_search_form']
		]); ?>
    <div class="blog_post_col-1">
		<?= $form->field($model, 'category')
			->dropDownList($translationModel->categoriesList, ['options' => ['main' => ['Selected' => TRUE]]])
			->label(Yii::t('translation', 'CATEGORY')); ?>
		<?= $form->field($model, 'message', ['errorOptions' => ['class' => 'help-block' ,'encode' => false]])->label(Yii::t('translation', 'MESSAGE')); ?>
    </div>
    <div class="blog_post_col-2">
		<?php
                    foreach ($translationModel->translations as $lang => $translation){ ?>
                    <div class="add_trans">
                            <label class="control-label" for='trans_<?= $lang ?>'><?= $lang ?></label>
                            <?= Html::textarea("messageTranslations[$lang]", $translation, ['id' => 'trans_' . $lang]); ?>
                    </div>
		<?php
			}
		?>
    </div>
    <div class="blog_post_col_submit">
		<div class="form-group trans_save">
			<?= Html::submitButton(Yii::t('translation', 'SAVE'), ['class' => 'btn btn-primary']); ?>
			<?= Html::a(Yii::t('translation', 'CANCEL'), ['/translation/default/index'], ['class' => 'btn btn-default']); ?>
		</div>
    </div>
	<?php ActiveForm::end(); ?>
</div>
