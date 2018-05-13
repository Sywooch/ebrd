<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Profile;
use yii\helpers\Html;
use rmrevin\yii\fontawesome\FA;
use common\models\User;
use common\models\Invitation;
use yii\helpers\ArrayHelper;

frontend\modules\user\bundles\UserModuleAsset::register($this);
/* @var $model frontend\models\User */
/* @var $searchModel frontend\modules\user\models\UserSearch */
/* @var $statuses array */
/* @var $roles array */
$this->title = Yii::t('user', 'SEO_CLUB_INGOING');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Yii::$app->cache->flush(); ?>
<div class="user-default-index">
	
	<div class="main_block_class">
		<span class="main_action_title"><?= Html::encode($this->title) ?></span>
	</div>
	
	<?php Pjax::begin(); ?>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'layout'=>'<div class="grid_over">{items}</div>{pager}',
		'columns' => [
			'id',
			'email',
			[
				'attribute' => 'seo_member_status',
				'filter' =>  $statuses,
                'label' => Yii::t('user', 'SEO_CLUB_STATUSES'),
				'content' => function ($model) {
					return Html::tag('div', $model->seo_member_status);
				}
				],
			
            [
                'label' => Yii::t('blog', 'ACTIONS'),
				'content' => function ($model) {
					$options['class'] = 'ajax-change-club-status';
					$options['data'] = [
						'user_id' => $model->id,
					];
					
					if ($model->seo_member_status == Profile::ADDED_TO_SEO_CLUB) {
						$status = Yii::t('user', 'REJECT');
						$options['class'] .= ' btn btn-warning';
						$options['data']['action'] = 'add';
						return Html::button(Html::tag('div', $status, $options));
					} elseif ($model->seo_member_status == Profile::AWAITING_ADD_SEO_CLUB) {
						$firstOpt = $options;
						$firstOpt['class'] .= ' btn btn-success';
						$firstOpt['data']['action'] = 'add';
						$buttons = Html::button(
							Html::tag('div', Yii::t('user', 'ADD'), $firstOpt)
						);
						$secOpt = $options;
						$secOpt['class'] .= ' btn btn-warning';
						$secOpt['data']['action'] = 'reject';
						return $buttons .= Html::button(
							Html::tag('div', Yii::t('user', 'REJECT'), $secOpt)
						);
						
					} elseif ($model->seo_member_status == Profile::SEO_CLUB_REJECTED) {
						$status = Yii::t('user', 'ADD');
						$options['class'] .= ' btn btn-success';
						$options['data']['action'] = 'reject';
						return Html::button(Html::tag('div', $status, $options));
					}
				}
			],
		]
	]); ?>
	<?php Pjax::end(); ?>
</div>