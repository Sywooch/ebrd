<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Invitation;

$this->title = Yii::t('blog', 'CABINET');
?>

<div class="main_cabinet_wrap">
	<div class="main_block_class">
		<span class="main_action_title"><?= Html::encode($this->title) ?></span>
	</div>
	
	<div class="cabinet_main_page">
		<div class="pretty_block_cabinet_container">
			<div class="pretty_block_cabinet">
				<div class="pretty_block_cabinet_image">
					<?= Html::a('<svg><use xlink:href="#left_7"></use></svg>',Url::to(['/cabinet/market'])) ?>
				</div>
				<div class="pretty_block_cabinet_text">
					<?= Html::a(Yii::t('blog', 'CABINET_BLOGS'),Url::to(['/cabinet/blogs'])) ?>
				</div>
			</div>
		</div>

	</div>
</div>
