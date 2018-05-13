<?php
use yii\helpers\Url;
use frontend\modules\blog\models\BlogStakeholder;
use common\models\User;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<div class="stakeholder__container">
	<div class="stakeholder__image-container"><img class="stakeholder__image" src="<?= '/images/stakeholders_logo/'.$model->logo ?>"></div>
	<div class="stakeholder__title"><span><?= ((mb_strlen($model->name, 'UTF-8') > 70) ? (mb_substr($model->name, 0, 70).'...') : ($model->name)) ?></span></div>

	<div class="stakeholder__whois-box">
		<div class="stakeholder__whois"><?= $model->getCategoryName($model->group_id) ?></div>
		<div class="stakeholder__whois"><?= $model->location ?></div>
	</div>

	<div class="stakeholder__box">
		<span class="stakeholder__bold"><?= Yii::t('blog', 'STAKEHOLDER_TELEPHONE') ?>: </span>
		<span class="stakeholder__thin"><?= $model->phone ?></span>
	</div>

	<div class="stakeholder__box">
		<span class="stakeholder__bold"><?= Yii::t('blog', 'STAKEHOLDER_MAIL') ?>: </span>
		<span class="stakeholder__thin"><?= $model->mail ?></span>
	</div>

	<div class="stakeholder__buttons">
		<a class="button" href="<?= Url::to(['/blog/stakeholder/front-view', 'id' => $model->id]) ?>" class="button"><?= Yii::t('blog', 'STAKEHOLDER_VIEW_DETAILS') ?></a>
		<div class="flex__aic"><svg><use xlink:href="#svg_envelope"></use></svg><a class="stakeholder__link" href="mailto:<?= $model->mail ?>"><?= Yii::t('blog', 'STAKEHOLDER_MAIL_TO')?></a></div>
	</div>

</div>