<?php

use yii\helpers\Html;
use frontend\models\HdbkLanguage;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogPost */

$this->title = Yii::t('blog', 'Update {modelClass}: ', [
    'modelClass' => 'Blog Post',
]) . $model->name;

foreach ($translationBtns as $key => $val){
	if($key !== $model->lang->code){
		echo Html::a('<span class="glyphicon glyphicon-pencil" style="padding-right:5px;"></span>'.Yii::t('blog', HdbkLanguage::getLanguageByCode($key)->name), ['update?id='.$val], ['class' => 'btn btn-primary','style' => 'margin-right:5px;']);
	}
}

foreach ($emptyColTranslationArray as $emptyColTranslationBtn){
	if($emptyColTranslationBtn !== 'alias'){
		echo Html::a('<span class="glyphicon glyphicon-plus" style="padding-right:5px;"></span>'.Yii::t('blog', HdbkLanguage::getLanguageByCode($emptyColTranslationBtn)->name), ['create-translation?id='.$model->id.'&translate_to='.$emptyColTranslationBtn], ['class' => 'btn btn-success','style' => 'margin-right:5px;']);
	}
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'POSTS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('blog', 'UPDATE');
?>
<div class="blog-post-update">

    <div class="main_block_class">
		<span class="main_action_title"><?= Html::encode($this->title) ?></span>
	</div>

    <?= $this->render('_form', [
        'model' => $model,
		'items' => $items,
		'parent' => $parent,
		'translateRow' => $translateRow,
		'authors' => $authors,
    ]) ?>

</div>
