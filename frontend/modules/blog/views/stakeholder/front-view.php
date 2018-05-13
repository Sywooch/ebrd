<?php

use yii\helpers\Html;
use yii\helpers\Url;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$url = \yii\helpers\Url::to(['/blog/stakeholder/location-list']);
$this->title = $model->name;
?>

<div class="stakeholder-view">

	<div class="stakeholder-view__hero">
<!-- 				<div class="breadcrumbs">
					<?= Html::a(Yii::t('blog','MAIN'), Url::to(['/']))
					.'<span> > </span>'
					.Html::a(Yii::t('blog','EVENTS'), Url::to(['/blog/events']))
					.'<span> > </span>'
					.'<span class="breadcrumbs__current">'.$model->name.'</span>' ?>
				</div> -->
				<div class="stakeholder-view__container">

					<div class="stakeholder-view__box">
						<div class="stakeholder-view__title"><?= $model->name ?></div>

						<div class="stakeholder-view__flex">
							<div class="flex__fdc">
								<div class="stakeholder-view__bold"><?= $model->getCategoryName($model->group_id) ?></div>
								<div class="stakeholder-view__bold"><?= $model->location ?></div>
							</div>
							<div class="flex__fdc">
								<div class="flex">
									<span class="stakeholder-view__bold"><?= Yii::t('blog', 'STAKEHOLDER_MAIL') ?>: </span>
									<span class="stakeholder-view__thin"><?= $model->mail ?></span>
								</div>

								<div class="flex">
									<span class="stakeholder-view__bold"><?= Yii::t('blog', 'STAKEHOLDER_TELEPHONE') ?>: </span>
									<span class="stakeholder-view__thin"><?= $model->phone ?></span>
								</div>
							</div>
						</div>

					</div>

					<div class="stakeholder-view__image-container"><img class="stakeholder-view__image" src="<?= '/images/stakeholders_logo/'.$model->logo ?>"></div>

				</div>
			</div>

			<div class="stakeholder-view__content">
				<div class="stakeholder-view__content-title"><?= Yii::t('blog', 'STAKEHOLDER_ABOUT_COMPANY').':' ?></div>
				<div class="stakeholder-view__text"><?= $model->description ?></div>
			</div>

		</div>