<?php

use yii\helpers\Html;
use frontend\models\HdbkLanguage;

/* @var $this yii\web\View */
/* @var $model frontend\modules\letter\models\Letter */
/* @var $translationBtns frontend\modules\letter\models\Letter */
/* @var $emptyColTranslationArray frontend\modules\letter\models\Letter */
/* @var $items frontend\modules\letter\models\Letter */
/* @var $translateRow frontend\modules\letter\models\Letter */
/* @var $oldModel frontend\modules\letter\models\Letter */
/* @var $translate frontend\modules\letter\models\Letter */

$this->title = 'Update Letter: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'LETTERS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

foreach ($translationBtns as $key => $val){
    if($key !== $model->lang->code){
        echo Html::a('<span class="glyphicon glyphicon-pencil" style="padding-right:5px;"></span>'.Yii::t('blog', HdbkLanguage::getLanguageByCode($key)->name), ['update?id='.$val], ['class' => 'btn btn-primary','style' => 'margin-right:5px;']);
    }
}

foreach ($emptyColTranslationArray as $emptyColTranslationBtn){
    if($emptyColTranslationBtn !== 'alias'){
        echo Html::a('<span class="glyphicon glyphicon-plus" style="padding-right:5px;"></span>'.Yii::t('blog', HdbkLanguage::getLanguageByCode($emptyColTranslationBtn)->name), ['create?translated_id='.$model->id.'&translate_to='.$emptyColTranslationBtn], ['class' => 'btn btn-success','style' => 'margin-right:5px;']);
    }
}

?>
<div class="letter-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'items' => $items,
        'translateRow' => $translateRow,
        'oldModel' => $oldModel,
        'translate' => $translate,
        'disabled' => false
    ]) ?>

</div>
