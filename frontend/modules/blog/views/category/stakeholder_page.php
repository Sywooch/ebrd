<?php

use yii\widgets\ListView;
use yii\widgets\Pjax;
use frontend\modules\blog\models\SearchBlogStakeholder;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$model	= new SearchBlogStakeholder();
$lang = Yii::$app->language;
$this->title = Yii::t('blog', 'STAKEHOLDER_TITLE');
?>
<div class="stakeholders">
	<div class="stakeholders-search">
		<?= $this->render('/stakeholder/_search', [
			'model'	=> $model
		]); ?>
	</div>
	<?php
		Pjax::begin(['id' => 'stakeholderview']);
		echo ListView::widget([
		'dataProvider' => $dataProvider,
		'itemView' => '_stakeholder_list',
		'summary' => '',
		'options' => [
			'tag' => 'div',
			'class' => 'stakeholders__container',
		],
		'itemOptions' => [
			'tag' => 'div',
			'class' => 'stakeholder',
		],
		'pager' => [
			'linkOptions' => [
				'rel' => 'nofollow',
			],
		],
	]);
	?>
</div>

<?php
	Pjax::end();
	$js = <<<JS
function bindChange(){
	$('#searchgroup').change(function(){
		if(this.value != ''){
			$('#searchform').submit();
		}
	});
	$('#locationselect').change(function(){
		if(this.value != ''){
			$('#searchform').submit();
		}
	});	
}
$('document').ready(function(){
	bindChange();
	$('#stakeholdersearch').on('pjax:end', function() {
		$.pjax.reload({container:'#stakeholderview'});  //Reload ListView
		bindChange();
	});
});
JS;
	$this->registerJs($js);
	?>
