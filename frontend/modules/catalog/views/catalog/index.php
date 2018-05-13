<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use frontend\modules\team\models\Team;
use frontend\modules\plugins\models\PluginsCountryLocationCode; 
use frontend\modules\catalog\models\CatalogIndustry;
use frontend\modules\catalog\models\CatalogDocType;
use frontend\modules\catalog\models\CatalogProjectType;
use frontend\modules\catalog\models\CatalogMethodCollectingData;
use frontend\modules\catalog\models\CatalogMethodAnalysisData;
use frontend\modules\catalog\models\CatalogDocument;
use kartik\select2\Select2;
use kartik\daterange\DateRangePicker;


/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\catalog\models\CatalogDocumentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('catalog', 'Catalog Documents');
$this->params['breadcrumbs'][] = $this->title;


//yii::$app->cache->flush();
?>
<div class="catalog-document-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(['linkSelector' => 'a.dummy']); ?>
    <?php  
	
	echo $this->render('_search', ['model' => $searchModel]); 	?>
	
    <p>
        <?= Html::a(Yii::t('catalog', 'Create Catalog Document'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	<div style="overflow-x: auto">
		
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',		
			[
				'attribute' => 'client_id',
				'filter' => Select2::widget([
					'name' => 'CatalogDocumentSearch[client_id]',
					'value' => $searchModel->client_id, 
					'data' => ArrayHelper::map(CatalogDocument::getClients($searchModel), 'id', 'name'),
					'size' => Select2::MEDIUM,
					'options' => ['placeholder' => 'Select a Client ...'],
					'pluginOptions' => [
						'allowClear' => true
						],
				]),
				'value' => function ($model) {
					return $model->client->name;
				}			
			],
			'contract_number',
			[
				'attribute' => 'contract_date',
				'filter' => DateRangePicker::widget([
								'name' => 'CatalogDocumentSearch[contract_date]',
								'value'=> $searchModel->contract_date,
								'convertFormat'=>true,
								'useWithAddon'=>true,
								'presetDropdown'=>true,
								'pluginOptions'=>[
									'locale'=>[
										'format'=>'Y-m-d',
										'separator'=>' to ',
									],
									'opens'=>'left'
								]])
			],
			[
				'attribute' => 'country_id',
				'filter' => Select2::widget([
					'name' => 'CatalogDocumentSearch[country_id]',
					'value' => $searchModel->country_id ,
					'data' => ArrayHelper::map(CatalogDocument::getCountries(), 'id', 'country_name'),
					'size' => Select2::MEDIUM,
					'options' => ['placeholder' => 'Select a Country ...'],
					'pluginOptions' => [
						'allowClear' => true
						],
				]),
				'value' => function ($model) {
					return $model->country->country_name;
				}			
			],
			[
				'attribute' => 'industry_id',
				'filter' => ArrayHelper::map(CatalogDocument::getIndustries(), 'id', 'name'),
				'value' => function ($model) {
					return yii::t('catalog',$model->industry->name);
				}			
			],
			[
				'attribute' => 'projects',
				'format' => 'raw',
				'label' => Yii::t('Catalog', 'CATALOG_PROJECTS'),
				'filter' => ArrayHelper::map(CatalogDocument::getProjects(), 'id', 'name'),
				'value' => function ($model) {
					$projects = $model->catalogDocumentToProjects;
					$value = '';
					foreach ($projects as $project){
						$value .= '<p>'.yii::t('catalog',$project->projectType->name).'</p>';						
					}
					return $value;
				}			
			],
			[
				'attribute' => 'method_collecting_id',
				'format' => 'raw',
				'label' => Yii::t('Catalog', 'METHOD_COLLECTION'),
				'filter' => ArrayHelper::map(CatalogDocument::getMethodsCollection(), 'id', 'name'),
				'value' => function ($model) {
					$methodCollectings = $model->catalogDocumentToMethodCollectings;
					$value = '';
					foreach ($methodCollectings as $method){
						$value .= '<p>'.yii::t('catalog',$method->methodCollecting->name).'</p>';						
					}
					return $value;
				}			
			],
			[
				'attribute' => 'method_analisis_id',
				'format' => 'raw',
				'label' => Yii::t('Catalog', 'METHOD_ANALISIS'),
				'filter' => ArrayHelper::map(CatalogDocument::getMethodsAnalisis(), 'id', 'name'),
				'value' => function ($model) {
					$methodAnalisis = $model->catalogDocumentToMethodAnalises;
					$value = '';
					foreach ($methodAnalisis as $method){
						$value .= '<p>'.yii::t('catalog',$method->methodAnalisis->name) .'</p>';						
					}
					return $value;
				}			
			],
			[
				'attribute' => 'doc_type_id',
				'filter' => ArrayHelper::map(CatalogDocument::getDocTypes(), 'id', 'name'),
				'value' => function ($model) {
					return Yii::t('catalog', $model->docType->name);
				}			
			],
			[
				'label' => Yii::t('Catalog', 'CATALOG_PERIOD_DATE'),
				'filter' => DateRangePicker::widget([
								'name' => 'CatalogDocumentSearch[period_date]',
								'value'=> $searchModel->period_date,
								'convertFormat'=>true,
								'useWithAddon'=>true,
								'presetDropdown'=>true,
								'pluginOptions'=>[
									'locale'=>[
										'format'=>'Y-m-d',
										'separator'=>' to ',
									],
									'opens'=>'left'
								]]),
				'value' => function ($model) {
					return $model->period_start_date.' - '.$model->period_end_date ;
				}				
			],
			[
				'attribute' => 'file',
				'format' => 'raw',
				'value' => function ($model) {
					return Html::a(Yii::t('edu', $model->filename),
						[
						'download',
						'file' => $model->file,
						'name' => $model->filename,						
						] );
				},				
			],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
			</div>
    <?php Pjax::end(); ?>
</div>
