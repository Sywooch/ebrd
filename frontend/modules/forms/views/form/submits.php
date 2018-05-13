<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = Yii::t('forms', 'SUBMITS');
$this->params['breadcrumbs'][] = ['label' => Yii::t('forms', 'FORMS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('forms', 'FORM_{formName}_RESULTS', ['formName' => $formName]);
?>
<div class="form-index">

    <h1><?= Html::encode($this->title) ?></h1>

<?php Pjax::begin([
	'options' => [
		'id' => 'formSubmits'
		]
	]); ?>    
<?= GridView::widget(['dataProvider' => $dataProvider]); ?>
<?php Pjax::end(); ?></div>