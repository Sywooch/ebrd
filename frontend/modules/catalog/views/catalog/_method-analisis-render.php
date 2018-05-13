<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use frontend\modules\catalog\models\CatalogMethodAnalysisData;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo '<div class="form-group field-method_analisis-'.$maindex.' required has-success">';
echo Html::dropDownList('CatalogDocument[method_analisis]['.$maindex.']', null, ArrayHelper::map(CatalogMethodAnalysisData::getTranslatedAnalysisMethods(['not',['id' => $method_analisis_id]]), 'id', 'name'), [
	'prompt' => Yii::t('catalog', 'CATALOG_CHOOSE_METHOD_ANALISIS_DATA'),
	'id' => 'method_analisis-'.$maindex,
	'class' => 'form-control'
	]);
echo '</div>';