<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('blog', 'GO_TO_MARKET');
?>
<div class="main_block_class">
	<span class="main_action_title"><?= Html::encode($this->title) ?></span>
</div>
<div class="market">
	<div class="video_market">
		<?php
			if(Yii::$app->language === 'en'){
				echo '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/mOywzqyvjzY?rel=0&autoplay=1" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>';
			}else{
				echo '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/-wCrRYSW1wA?rel=0&autoplay=1" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>';
			}
		?>
	</div>
	<div class="text_market">
		<?php
			$code = (Yii::$app->language === 'en') ? '' : '/'.Yii::$app->language;
		?>
		<div class="market_p_first"><?= Yii::t('blog', 'MARKET_ONE'); ?></div>
		<div class="market_p_last"><?= Yii::t('blog', 'MARKET_TWO').' <a target="_blank" href="/uk/methods/conjoint-analysis">'.Yii::t('blog', 'MARKET_LINK').'</a>'; ?></div>
<!--		[button title=HOC chainname=ad_hoc extraclass=btn id=openConjoint]-->
		<div class="btn_chain">
			<a class="btn_hubspot" href="https://app.hubspot.com/meetings/yuriy-shchyrin" target="_blank"><?= Yii::t('blog', 'ASSIGN_MEETING'); ?></a>
			[button title=BRIEF_CONJOIN chainname=Conjoint extraclass=btn id=openConjoint]
		</div>
	</div>
</div>
