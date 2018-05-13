<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\web\UrlManager; 
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\catalog\models\CatalogDocumentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('catalog', 'CATALOG_ELEMENTS');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-elements-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php 
	foreach ($dataProviders as $className => $provider) :
		Pjax::begin(); 
//		array_push($provider['columns'],
//			['class' => 'yii\grid\ActionColumn',
//			'template' => '{delete} {update}',
//			'urlCreator' => function ($action, $model, $key, $index) use ($className)
//			{
//				if ($action === 'delete') {
//					$url ='delete-element?&id='.$model->id.'&class='.$className;
//					return $url;
//				}
//				if ($action === 'update') {
//					$url ='update-element?&id='.$model->id.'&class='.$className;
//					return $url;
//				}
//			}
//		]);
	?>
    <p>
        <?= Html::a(Yii::t('catalog', 'Create_'.$className.'_element'), ['create-element','class'=>$className], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget(
		[
        'dataProvider' => $provider['data'],
        'columns' => $provider['columns'],
		]
		); 
	?>
    <?php
		Pjax::end();
		endforeach;
	?>
</div>