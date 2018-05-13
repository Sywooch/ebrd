<?php

use yii\helpers\Html;
use frontend\models\HdbkLanguage;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogGroup */

$this->title = Yii::t('blog', 'Update Blog Group: {nameAttribute}', [
    'nameAttribute' => $model->name,
]);

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

$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'GROUPS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('blog', 'UPDATE');
?>
<div class="blog-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'items' => $items,
		'translateRow' => $translateRow,
    ]) ?>

</div>
