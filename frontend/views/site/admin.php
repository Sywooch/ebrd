<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Invitation;

$this->title = Yii::t('blog','ADMIN')
?>

<div class="admin_main_page_wrap">
	<div class="main_block_class">
		<span class="main_action_title"><?= Html::encode($this->title) ?></span>
	</div>
	<div class="admin_main_page_container">
		<div class="admin_main_page_block">
			<div class="admin_main_page_block_shadow">
				<div class="admin_main_page_block_image">
					<svg><use xlink:href="#left_17"></use></svg>
				</div>
				<div class="admin_main_page_block_title">
					<?= Yii::t('blog','CMS') ?>
				</div>
				<div class="admin_main_page_block_list">
					<ul class="admin_main_list">
					<?= '<li>'.Html::a(Yii::t('blog', 'POSTS'),Url::to(['/blog/post'])).'</li>' ?>
					<?= '<li>'.Html::a(Yii::t('blog', 'CATEGORIES'),Url::to(['/blog/category'])).'</li>' ?>
					<?= '<li>'.Html::a(Yii::t('blog', 'GROUPS'),Url::to(['/blog/group'])).'</li>' ?>
					<?= '<li>'.Html::a(Yii::t('plugins', 'FORMS'),Url::to(['/forms/form'])).'</li>' ?>
					<?= '<li>'.Html::a(Yii::t('forms', 'FORMCHAINS'),Url::to(['/forms/formchain'])).'</li>' ?>
					<?= '<li>'.Html::a(Yii::t('plugins', 'PLUGINS'),Url::to(['/plugins/plugin'])).'</li>' ?>
					<?= '<li>'.Html::a(Yii::t('blog', 'AUTO LINKER'),Url::to(['/plugins/autolinker'])).'</li>' ?>
					<?= '<li>'.Html::a(Yii::t('blog', 'CONTACTS'),Url::to(['/blog/contacts'])).'</li>' ?>
					<?= '<li>'.Html::a(Yii::t('blog', 'MEDIA'),Url::to(['/imagemanager'])).'</li>' ?>
					<?= '<li>'.Html::a(Yii::t('blog', 'SETTINGS'),Url::to(['/settings/settings'])).'</li>' ?>
					<?= '<li>'.Html::a(Yii::t('blog', 'REDIRECTS'),Url::to(['/redirects'])).'</li>' ?>
					<?= '<li>'.Html::a(Yii::t('blog', 'TOKENS'),Url::to(['/user/user-token'])).'</li>' ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="admin_main_page_block">
			<div class="admin_main_page_block_shadow">
				<div class="admin_main_page_block_image">
					<svg><use xlink:href="#left_16"></use></svg>
				</div>
				<div class="admin_main_page_block_title">
					<?= Yii::t('blog','SETTINGS') ?>
				</div>
				<div class="admin_main_page_block_list">
					<ul class="admin_main_list">
					<?= '<li>'.Html::a(Yii::t('user', 'USERS'),Url::to(['/user/default'])).'</li>' ?>
					<?= '<li>'.Html::a(Yii::t('blog', 'TRANSLATIONS'),Url::to(['/translation/default'])).'</li>' ?>
					<?= '<li>'.Html::a(Yii::t('blog', 'LETTERS'),Url::to(['/letter/letter'])).'</li>' ?>
					<?= '<li>'.Html::a(Yii::t('blog', 'REPORTS_ADMIN'),Url::to(['/user/reports'])).'</li>' ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="admin_main_page_block">
			<div class="admin_main_page_block_shadow">
				<div class="admin_main_page_block_image">
					<svg><use xlink:href="#left_14"></use></svg>
				</div>
				<div class="admin_main_page_block_title">
					<?= Yii::t('blog','CABINET') ?>
				</div>
				<div class="admin_main_page_block_list">
					<ul class="admin_main_list">
					<?= '<li>'.Html::a(Yii::t('blog', 'MAIN'),Url::to(['/cabinet'])).'</li>' ?>
					<?= '<li>'.Html::a(Yii::t('blog', 'MY_MARKETING'),Url::to(['/cabinet/my-marketing-strategy'])).'</li>' ?>
					<?= '<li>'.Html::a(Yii::t('blog', 'MARKETING_ANALITYC'),Url::to(['/cabinet/reports'])).'</li>' ?>
					<?= '<li>'.Html::a(Yii::t('blog', 'INDUSTRIAL_STATISTIC'),Url::to(['/cabinet/industrial'])).'</li>' ?>
					<?= '<li>'.Html::a(Yii::t('blog', 'NPS'),Url::to(['/cabinet/nps'])).'</li>' ?>
					<?= '<li>'.Html::a(Yii::t('blog', 'GEOMARKETING'),Url::to(['/cabinet/geomarketing'])).'</li>' ?>
					<?= '<li>'.Html::a(Yii::t('blog', 'MANUALS'),Url::to(['/cabinet/manuals'])).'</li>' ?>
					<?= '<li>'.Html::a(Yii::t('blog', 'GO_TO_MARKET'),Url::to(['/cabinet/market'])).'</li>' ?>
					<?= '<li>'.Html::a(Yii::t('blog', 'LEAD_GENERATION'),Url::to(['/cabinet/lead-generation'])).'</li>' ?>
					<?= '<li>'.Html::a(Yii::t('blog', 'TEAM'),Url::to(['/cabinet/team'])).'</li>' ?>
					<?= '<li>'.Html::a(Yii::t('blog', 'PROFILE'),Url::to(['/cabinet/profile'])).'</li>' ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

