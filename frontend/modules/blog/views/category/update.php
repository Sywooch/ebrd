<?php

use yii\helpers\Html;
use frontend\models\HdbkLanguage;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogCategory */

$this->title = Yii::t('blog', 'Update {modelClass}: ', [
    'modelClass' => 'Blog Category',
]) . $model->name;

foreach ($translationBtns as $key => $val){
	if($key !== $model->lang->code){
		echo Html::a('<span class="glyphicon glyphicon-pencil" style="padding-right:5px;"></span>'.Yii::t('blog', HdbkLanguage::getLanguageByCode($key)->name), ['update?id='.$val], ['class' => 'btn btn-primary','style' => 'margin-right:5px;']);
	}
}

foreach ($emptyColTranslationArray as $emptyColTranslationBtn){
	if($emptyColTranslationBtn !== 'alias'){
		$text = '<span class="glyphicon glyphicon-plus" style="padding-right:5px;"></span>'.Yii::t('blog',	HdbkLanguage::getLanguageByCode($emptyColTranslationBtn)->name);
		$url = ['create-translation?id='.$model->id.'&translate_to='.$emptyColTranslationBtn];
		$options = ['class' => 'btn btn-success','style' => 'margin-right:5px;'];
		echo Html::a($text, $url, $options);
	}
}

unset($parent[$model->id]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'CATEGORIES'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('blog', 'UPDATE');
?>
<div class="blog-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'items' => $items,
        'parent' => $parent,
        'groups' => $groups,
        'translateRow' => $translateRow,
		'layouts' => $layouts,
    ]) ?>

</div>
