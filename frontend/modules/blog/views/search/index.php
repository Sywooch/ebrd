<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use frontend\modules\blog\models\SearchForm;
$model = new SearchForm();

/* @var $this yii\web\View */
/** @var $dataProvider\frontend\modules\blog\models\SearchForm */

$this->title = Yii::t('blog', 'SEARCH') . ': ' . $q;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="search-page-title">

</div>
<div class="not_found_search not_found_search_page">
	<?php
	$form = ActiveForm::begin([
				'id' => '403_search',
				'action' => ['/blog/search/search'],
				'method' => 'GET'
	]);
	?>
	<div class="form_search_wrap">
		<?= $form->field($model, 'q')->textInput(['class' => 'input', 'value' => Yii::t('blog', $q)])->label('') ?>
	<?php echo Html::submitButton('<svg><use xlink:href="#s_glass_icon"></use></svg>', ['class' => 'search_btn_f']) ?>
	</div>
<?php ActiveForm::end(); ?>
	<span><span></span></span>

</div>
<?php
echo ListView::widget([
	'dataProvider' => $listDataProvider,
	'itemView' => '_list',
	'options' => [
		'tag' => 'div',
		'class' => 'list-wrapper',
		'id' => 'list-wrapper',
	],
	'pager' => [
		'firstPageLabel' => '<i class="fa fa-angle-double-left" aria-hidden="true"></i>',
		'lastPageLabel' => '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
		'nextPageLabel' => '<i class="fa fa-angle-right" aria-hidden="true"></i>',
		'prevPageLabel' => '<i class="fa fa-angle-left" aria-hidden="true"></i>',
		'maxButtonCount' => 3,
	],
]);
?>
