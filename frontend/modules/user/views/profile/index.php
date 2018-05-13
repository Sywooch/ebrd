<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\user\models\ProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

frontend\modules\user\bundles\UserModuleAsset::register($this);

$this->title = Yii::t('user', 'PROFILE');
?>

<p class="cabinet-title"><?= Html::encode($this->title) ?></p>

<div class="cabinet-profile">
	<div class="cabinet-profile__container">
		<div class="cabinet-profile__avatar">
			<?php
			if(!empty($model->avatar)){
				echo '<img src="/images/avatars/'.$model->avatar.'">';
			}else{
				echo '<img src="/images/avatars/def_avatar.png">';
			}
			?>
		</div>

		<div class="cabinet-profile__box">

			<div class="cabinet-profile__name-container">
				<div class="flex__aic">
					<div class="cabinet-profile__name">
						<?php
						if(!empty($model->full_name)){
							echo $model->full_name;
						}else{
							echo Yii::t('user', 'NOT_SPECIFIED');;
						}
						?>
					</div>

					<span class="cabinet-profile__name-separator">|</span>

					<div class="cabinet-profile__profession">
						<?php if(!empty($model->profession)){
							echo $model->profession;
						}else{
							echo Yii::t('user', 'NOT_SPECIFIED');;
						}
						?>
					</div>
				</div>
				<?php if ($model && $model->user->id === Yii::$app->user->id){  ?>
					<?= Html::a(Yii::t('blog', 'EDIT'), ['settings'], ['class' => 'cabinet-profile__edit button'])?>
					<?php
				} ?>
			</div>

			<div class="cabinet-profile__info-container">

				<div class="flex">
					<div class="cabinet-profile__info-item">
						<svg><use xlink:href="#svg_pin"></use></svg>
						<span><?php
						if(!empty($model->city)){
							echo $model->city;
						}else{
							echo Yii::t('user', 'NOT_SPECIFIED');;
						}
						?></span>
					</div>

					<div class="cabinet-profile__info-item">
						<svg><use xlink:href="#svg_envelope"></use></svg>
						<span><?= $model->user->email; ?></span>
					</div>
				</div>

				<div class="flex">
					<div class="cabinet-profile__info-item">
						<svg><use xlink:href="#svg_phone"></use></svg>
						<span><?php
						if(!empty($model->phone)){
							echo $model->phone;
						}else{
							echo Yii::t('user', 'NOT_SPECIFIED');;
						}
						?></span>
					</div>

					<div class="cabinet-profile__info-item">
						<svg><use xlink:href="#svg_phone2"></use></svg>
						<span><?php
						if(!empty($model->second_phone)){
							echo $model->second_phone;
						}else{
							echo Yii::t('user', 'NOT_SPECIFIED');;
						}
						?></span>
					</div>
				</div>

			</div>

		</div>
	</div>

	<div class="cabinet-profile__box">
		<p class="cabinet-profile__title">
			<?= Yii::t('user', 'BIOMASS_EXPERTISE') ?>
		</p>

		<span><?php
		if(!empty($model->biomass_expertise)){
			echo $model->biomass_expertise;
		}else{
			echo Yii::t('user', 'NOT_SPECIFIED');;
		}
		?></span>
	</div>


</div>
