<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\user\models\PartnerBonusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('blog', 'PARTNER');
?>
<div class="partner-bonus-index">

    <div class="main_block_class">
		<span class="main_action_title"><?= Html::encode($this->title) ?></span>
	</div>

    <p class="partner_program_controls">
		[button title=PARTNER_PROGRAM_BTN formname=partnerProgram extraclass=partnerProgram]
		<?php
			if(Yii::$app->user->can('manageUsers')){
				echo Html::a(Yii::t('blog', 'Create Partner Bonus'), ['create'], ['class' => 'btn btn-success']);
			}
		?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'layout'=>'<div class="grid_over">{items}</div>{pager}',
        'columns' => [
			[
				'label' => 'ID',
				'visible' => Yii::$app->user->can('manageUsers'),
				'value'=>function ($model) {
					return $model->id;
				}
			],
            'company_name',
            'full_name',
            'position',
            'email',
            'phone',
            'proposition',
            'privacy',
            [
				'label' => Yii::t('blog', 'USER'),
				'visible' => Yii::$app->user->can('manageUsers'),
				'value'=>function ($model) {
					return User::getUserById($model->user_id)->email;
				}
			],
            'created_at',
			[
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('blog', 'ACTION'),
				'visible' => Yii::$app->user->can('manageUsers'),
            ],
        ],
    ]); ?>
</div>
