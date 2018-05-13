<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use frontend\modules\catalog\models\CatalogMethodCollectingData;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo '<div class="form-group field-method_collecting-'.$mcindex.' required has-success">';
echo Html::dropDownList('CatalogDocument[method_collecting]['.$mcindex.']', null, ArrayHelper::map(CatalogMethodCollectingData::getTranslatedCollectingMethods(['not',['id' => $method_collecting_id]]), 'id', 'name'), [
		'prompt' => Yii::t('catalog', 'CATALOG_CHOOSE_METHOD_COLLECTING_DATA'),
		'id' => 'method_collecting-'.$mcindex,
		'class' => 'form-control catalog-document__method-collecting',
	]);
echo '</div>';