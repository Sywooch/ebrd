<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\team\models\Team;
use yii\helpers\ArrayHelper;
use frontend\modules\plugins\models\PluginsCountryLocationCode;
use kartik\date\DatePicker;
use frontend\modules\catalog\models\CatalogIndustry;
use frontend\modules\catalog\models\CatalogDocType;
use frontend\modules\catalog\models\CatalogProjectType;
use frontend\modules\catalog\models\CatalogMethodAnalysisData;
use frontend\modules\catalog\models\CatalogMethodCollectingData;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model frontend\modules\catalog\models\CatalogDocument */
/* @var $form yii\widgets\ActiveForm */
$projectTypeIndex = 1;
$methodAnalisisIndex = 1;
$methodCollectingIndex = 1;
$fileinputIndex = 1;
$doctypeIndex = 1;
$psdIndex = 1;
$pedIndex = 1;
$periodIndex = 1;

?>

<div class="catalog-document">

    <?php $form = ActiveForm::begin(['id' => 'catalog-document-form', 'options'=>['enctype'=>'multipart/form-data']]); ?>
	
	<?= $form->field($model, 'contract_number')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'contract_date')->widget(DatePicker::class, [
			'language' => Yii::$app->language,
		])
	?>

    <?= $form->field($model, 'client_id')->dropDownList(ArrayHelper::map(Team::find()->asArray()->all(), 'id', 'name'),['prompt' => Yii::t('catalog', 'CATALOG_CHOOSE_CLIENT')]) ?>

    <?= $form->field($model, 'country_id')->dropDownList(ArrayHelper::map(PluginsCountryLocationCode::find()->asArray()->all(), 'id', 'country_name'), ['options' => ['250' => ['selected' => 'selected']]]) ?>

    <?= $form->field($model, 'industry_id')->dropDownList(ArrayHelper::map(CatalogIndustry::getTranslatedIndustries(), 'id', 'name'), ['prompt' => Yii::t('catalog', 'CATALOG_CHOOSE_INDUSTRY')]) ?>
	
	<div id="project-types" class="catalog-document__project-types">	
	<?php echo $form->field($model, 'project_type')->dropDownList(ArrayHelper::map(CatalogProjectType::getTranslatedProjectTypes(), 'id', 'name'), [
		'prompt' => Yii::t('catalog', 'CATALOG_CHOOSE_PROJECT_TYPE'),
		'id' => 'project_type-'.$projectTypeIndex,
		'name' => 'CatalogDocument[project_type]['.$projectTypeIndex.']'
		]);
		++$projectTypeIndex;
		?>
	</div>
	
	<?= Html::button('+', [
		'id' => 'catalog_add_new_project_type',
		'class' => 'btn catalog-document__npt',
		'disabled' => true]);
		?>
	
	<div id="analisis-methods" class="catalog-document__method-analisis">
	<?php echo $form->field($model, 'method_analisis')->dropDownList(ArrayHelper::map(CatalogMethodAnalysisData::getTranslatedAnalysisMethods(), 'id', 'name'), [
		'prompt' => Yii::t('catalog', 'CATALOG_CHOOSE_METHOD_ANALISIS_DATA'),
		'id' => 'method_analisis-'.$methodAnalisisIndex,
		'name' => 'CatalogDocument[method_analisis]['.$methodAnalisisIndex.']'
		]);
		++$methodAnalisisIndex;
		?>
	</div>
	
	<?= Html::button('+', [
		'id' => 'catalog_add_new_method_analisis',
		'class' => 'btn catalog-document__nma',
		'disabled' => true]);
		?>
	
	<div id="collecting-methods" class="catalog-document__method-collecting">
	<?php echo $form->field($model, 'method_collecting')->dropDownList(ArrayHelper::map(CatalogMethodCollectingData::getTranslatedCollectingMethods(), 'id', 'name'), [
			'prompt' => Yii::t('catalog', 'CATALOG_CHOOSE_METHOD_COLLECTING_DATA'),
			'id' => 'method_collecting-'.$methodCollectingIndex,
			'name' => 'CatalogDocument[method_collecting]['.$methodCollectingIndex.']',
			'class' => 'form-control catalog-document__method-collecting',
		]);
		++$methodCollectingIndex;
		?>
	</div>
	
	<?= Html::button('+', [
		'id' => 'catalog_add_new_method_collecting',
		'class' => 'btn catalog-document__nmc',
		'disabled' => true]);
		?>
	<div id="fileinputs" class="catalog-document__fileinputs">
		<div class="catalog-document__fileinput flex">
			<div>
				<label><?= Yii::t('catalog', 'CATALOG_FILE') ?></label>
				<?=	FileInput::widget([
					'pluginOptions'=>['allowedFileExtensions'=>['jpg', 'gif', 'png', 'pdf', 'jpeg', 'docx', 'xlsx', 'pbix', 'pptx', 'doc'],
						'showPreview' => false,
						'showUpload' => false,
						'showRemove' => false
						],
					'id' => 'fileinput-'.$fileinputIndex,
					'name' => 'file-'.$fileinputIndex
				]);
				++$fileinputIndex;
				?>
			</div>
			<?= $form->field($model, 'doc_type_id')->dropDownList(ArrayHelper::map(CatalogDocType::getTranslatedDoctypes(), 'id', 'name'), [
					'prompt' => Yii::t('catalog', 'CATALOG_CHOOSE_DOCTYPE'), 
					'class' => 'form-control catalog-document__doctype',
					'id' => 'doctype-'.$doctypeIndex,
					'name' => 'CatalogDocument[file_collection]['.$doctypeIndex.'][doc_type_id]',
				]);
				++$doctypeIndex;
				?>

			<div id="period-<?= $periodIndex ?>" class="catalog-document__period flex" style="display:none;">
				<?= $form->field($model, 'period_start_date')->widget(DatePicker::class, [
					'language' => Yii::$app->language,
					'options' => [
						'id' => 'psd-'.$psdIndex,
						'name' => 'CatalogDocument[file_collection]['.$psdIndex.'][period_start_date]'
					]
					
				]);
				++$psdIndex;
				?>

				<?= $form->field($model, 'period_end_date')->widget(DatePicker::class, [
					'language' => Yii::$app->language,
					'options' => [
						'id' => 'ped-'.$pedIndex,
						'name' => 'CatalogDocument[file_collection]['.$pedIndex.'][period_end_date]'
					]				
				]);
				++$pedIndex;
				?>
			</div>
			<?php ++$periodIndex; ?>
		</div>
	</div>
	
	<?= Html::button('+', [
		'id' => 'catalog_add_new_fileinput',
		'class' => 'btn catalog-document__fileinput-add'
		]);
		?>

    <?= $form->field($model, 'document_description')->textarea(['rows' => 3]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('catalog', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$js = <<<JS
var projectTypeIndex = $projectTypeIndex;
var methodAnalisisIndex = $methodAnalisisIndex;
var methodCollectingIndex = $methodCollectingIndex;
var fileinputIndex = $fileinputIndex;
var doctypeIndex = $doctypeIndex;
var psdIndex = $psdIndex;
var pedIndex = $pedIndex;
var periodIndex = $periodIndex;
var arr = [];
arr['ptid'] = [];
arr['maid'] = [];
arr['mcid'] = [];
$('#project_type-'+(projectTypeIndex-1)).change(function(){
	if(this.value != ''){
		document.getElementById('catalog_add_new_project_type').disabled = false;
	}
});
$('#catalog_add_new_project_type').click(function(){
	var project_type_id = document.getElementById('project_type-'+(projectTypeIndex-1)).value;
	if(project_type_id != ''){
		arr.ptid.push(project_type_id);
		$.ajax({
			type: 'POST',
			cache: false,
			url: '/catalog/catalog/ajax-project-type-render',
			data: {
				'project_type_id' : arr.ptid,
				'ptindex' : projectTypeIndex
			},
			success: function(response){
				++projectTypeIndex;
				$('#project-types').append(response);
			}
		});
	}
});
$('#method_analisis-'+(methodAnalisisIndex-1)).change(function(){
	if(this.value != ''){
		document.getElementById('catalog_add_new_method_analisis').disabled = false;
	}
});
$('#catalog_add_new_method_analisis').click(function(){
	var method_analisis_id = document.getElementById('method_analisis-'+(methodAnalisisIndex-1)).value;
	if(method_analisis_id != ''){
		arr.maid.push(method_analisis_id);
		$.ajax({
			type: 'POST',
			cache: false,
			url: '/catalog/catalog/ajax-method-analisis-render',
			data: {
				'method_analisis_id' : arr.maid,
				'maindex' : methodAnalisisIndex
			},
			success: function(response){
				++methodAnalisisIndex;
				$('#analisis-methods').append(response);
			}
		});
	}
});
$('#catalog_add_new_method_collecting').click(function(){
	var method_collecting_id = document.getElementById('method_collecting-'+(methodCollectingIndex-1)).value;
	if(method_collecting_id != ''){
		arr.mcid.push(method_collecting_id);
		$.ajax({
			type: 'POST',
			cache: false,
			url: '/catalog/catalog/ajax-method-collecting-render',
			data: {
				'method_collecting_id' : arr.mcid,
				'mcindex' : methodCollectingIndex
			},
			success: function(response){
				++methodCollectingIndex;
				$('#collecting-methods').append(response);
			}
		});
	}
});
$('#catalog_add_new_fileinput').click(function(){
	var filevalue = document.getElementById('fileinput-'+(fileinputIndex-1)).value;
	var doctypevalue = document.getElementById('doctype-'+(doctypeIndex-1)).value;
	if(filevalue != '' && doctypevalue != ''){
		$.ajax({
			type: 'POST',
			cache: false,
			url: '/catalog/catalog/ajax-fileinput-render',
			data: {
				'fileinputIndex' : fileinputIndex,
				'doctypeIndex' : doctypeIndex,
				'psdIndex' : psdIndex,
				'pedIndex' : pedIndex,
				'periodIndex' : periodIndex
			},
			success: function(response){
				++fileinputIndex;
				++doctypeIndex;
				++psdIndex;
				++pedIndex;
				++periodIndex;
				$('#fileinputs').append(response);
			}
		});
	}
});
$('.catalog-document__method-collecting').change(function(){
	if(this.value != ""){
		document.getElementById("catalog_add_new_method_collecting").disabled = false;
	} else {
		document.getElementById("catalog_add_new_method_collecting").disabled = true;
	}
});
$('#fileinputs').delegate('.catalog-document__doctype','change',function(){
	if(this.value != ""){
		var id = this.id
		arr = id.split('-');
		$.ajax({
			type: "POST",
			cache: false,
			url: "/catalog/catalog/ajax-isperiod",
			data: {
				"doctypeIndex" : this.value,
			},
			success: function(response){
				if(response == 1){
					$("#period-" + arr[1]).css("display", "flex");
				} else {
					$("#period-" + arr[1]).css("display", "none");
				}
			}
		});
	}
});	
JS;
$this->registerJs($js);
?>
