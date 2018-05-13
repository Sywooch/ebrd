<?php
use yii\widgets\ListView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('blog', 'TRANSFER_PRICING');
?>
<div class="main_block_class">
	<span class="main_action_title"><?= Html::encode($this->title) ?></span>
</div>
<div class="reports-index">
	<div class="users_report_important">
		<?= 
			ListView::widget([
				'dataProvider' => $dataProvider,
				'itemView' => '_report_list_view',
				'layout' => "<div class='report_container_view'>{items}</div>\n{pager}",
				'options' => [
					'class' => 'report_container_wrap',
				]
			]);
		?>
	</div>
</div>
