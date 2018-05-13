<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use frontend\modules\catalog\models\CatalogProjectType;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
echo '<div class="form-group field-project_type-'.$ptindex.' required has-success">';
echo Html::dropDownList('CatalogDocument[project_type]['.$ptindex.']', null, ArrayHelper::map(CatalogProjectType::getTranslatedProjectTypes(['not',['id' => $project_type_id]]), 'id', 'name'), [
	'prompt' => Yii::t('catalog', 'CATALOG_CHOOSE_PROJECT_TYPE'),
	'id' => 'project_type-'.$ptindex,
	'class' => 'form-control'
	]);
echo '</div>';