<?php

use yii\helpers\Html;

//echo '<pre>';
//var_dump($model);
//echo '</pre>';
//die();

?>
<div class="single_proj">
	<?=($model->owner_id == Yii::$app->user->id) ? 
		Html::tag('h2', \Yii::t('common/hint', 'YOUR_PROJECT') . ':', ['class' => 'subheader']) : 
		Html::tag('h2', \Yii::t('common/hint', 'OTHER_TEAMS'), ['class' => 'subheader']) 
	?>

	<div class="proj_name"><?=$model->name?></div>
	<div class="proj_email"><?=$model->user->email?></div>
	<div class="proj_link_wrap"><?= Html::a(\Yii::t('common/hint', 'TO_SELECT_PROJECT'), ['/site/select-project', 'projectId' => $model->id], ['class' => 'buttonStd'])?></div>
</div>
