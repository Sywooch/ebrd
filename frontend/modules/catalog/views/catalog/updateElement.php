<?php

use yii\helpers\Html;
use frontend\models\HdbkLanguage;

/* @var $this yii\web\View */
/* @var $model frontend\modules\catalog\models\CatalogDocument */
//$this->title = Yii::t('catalog', 'Update_'.$class.'_Element');
$this->title = Yii::t('catalog', 'Update_'.$class.'_Element: {nameAttribute}', [
    'nameAttribute' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('catalog', 'Catalog Documents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('catalog', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('translation', 'TRANSLATIONS_MANAGER'), 'url' => ['index']];

?>
<div class="catalog-document-update">

    <h1><?= Html::encode($this->title) ?></h1>
	
    <?= $this->render('_formElement', [
        'model' => $model,
    ]) ?> 
</div>
