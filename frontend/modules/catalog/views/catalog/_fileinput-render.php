<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use frontend\modules\catalog\models\CatalogDocType;
use kartik\file\FileInput;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo '<div class="catalog-document__fileinput flex">';
echo '<div class="form-group field-fileinput-'.$fileinputIndex.' required has-success">';
echo FileInput::widget([
				'language' => Yii::$app->language,
				'id' => 'fileinput-'.$fileinputIndex,
				'name' => 'file-'.$fileinputIndex,
				'pluginOptions'=>[
					'allowedFileExtensions'=>['jpg', 'gif', 'png', 'pdf', 'jpeg', 'docx', 'xlsx', 'pbix', 'pptx', 'doc'],
					'showPreview' => false,
					'showUpload' => false,
					'showRemove' => false
					],
				]);
echo '</div>';
echo Html::dropDownList('CatalogDocument[file_collection]['.$doctypeIndex.'][doc_type_id]', null, ArrayHelper::map(CatalogDocType::getTranslatedDoctypes(), 'id', 'name'), [
			'prompt' => Yii::t('catalog', 'CATALOG_CHOOSE_DOCTYPE'), 
			'class' => 'form-control catalog-document__doctype',
			'id' => 'doctype-'.$doctypeIndex,
	]);
echo '<div id="period-'.$periodIndex.'" class="catalog-document__period flex" style="display:none;">';
echo DatePicker::widget([
			'language' => Yii::$app->language,
			'id' => 'psd-'.$pedIndex,
			'name' => 'CatalogDocument[file_collection]['.$pedIndex.'][period_start_date]'
		]);
echo DatePicker::widget([
			'language' => Yii::$app->language,
			'id' => 'ped-'.$pedIndex,
			'name' => 'CatalogDocument[file_collection]['.$pedIndex.'][period_end_date]'
		]);
echo '</div>';
echo '</div>';