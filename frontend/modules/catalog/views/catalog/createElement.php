<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\catalog\models\CatalogDocument */
$this->title = Yii::t('catalog', 'Create_'.$class.'_Element');
$this->params['breadcrumbs'][] = ['label' => Yii::t('catalog', 'CATALOG_ELEMENTS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-document-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
		if (strpos($class,'CatalogDocType') !== false ){
			echo $this->render('_formDocType', ['model' => $model]);
		} else	 
		echo $this->render('_formElement', ['model' => $model]);
	?>

</div>
