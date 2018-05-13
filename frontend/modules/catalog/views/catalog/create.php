<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\catalog\models\CatalogDocument */

$this->title = Yii::t('catalog', 'CATALOG_CREATE_DOCUMENT');
$this->params['breadcrumbs'][] = ['label' => Yii::t('catalog', 'Catalog Documents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-document-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
