<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\helpers\Url;
use yii\bootstrap\NavBar;
use frontend\modules\blog\components\BlogBreadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\modules\blog\models\SearchForm;
use frontend\modules\blog\components\widgets\lang_switcher\LanguageSwitcher;
use common\models\Invitation;
use frontend\modules\user\models\Reports;
use common\models\AuthAssignment;

AppAsset::register($this);

$model = new SearchForm();

$url = Yii::$app->request->url;



if(Yii::$app->language == Yii::$app->params['settings']['defaultLanguage']){
	$url = substr($url, 1);
}else{
	$url = substr($url, 4);
}

$pos = strpos($url, "/");

if(is_int($pos)){
	$url = substr($url, 0, $pos);
}

$isDemoSession = FALSE;
$demoClass = '';

if(!empty(Yii::$app->user)){
	if(Yii::$app->user->id == 232){
		$isDemoSession = TRUE;
		$demoClass = 'demo_session';
	}
}

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<meta name="theme-color" content="#ac162c">
	<meta name="robots" content="noindex, nofollow">
	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) .' ‐ '. Yii::$app->name ?></title>
	<?php $this->head() ?>
	<?php if($url == 'cabinet'){ ?>
	<!-- Google Tag Manager -->
<!--		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':-->
<!--		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],-->
<!--		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=-->
<!--		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);-->
<!--		})(window,document,'script','dataLayer','GTM-WFS3R84');</script>-->
	<!-- End Google Tag Manager -->

    <!-- Yandex.Metrika counter -->
<!--    <script type="text/javascript" >-->
<!--        (function (d, w, c) {-->
<!--            (w[c] = w[c] || []).push(function() {-->
<!--                try {-->
<!--                    w.yaCounter47926829 = new Ya.Metrika2({-->
<!--                        id:47926829,-->
<!--                        clickmap:true,-->
<!--                        trackLinks:true,-->
<!--                        accurateTrackBounce:true,-->
<!--                        webvisor:true-->
<!--                    });-->
<!--                } catch(e) { }-->
<!--            });-->
<!---->
<!--            var n = d.getElementsByTagName("script")[0],-->
<!--                s = d.createElement("script"),-->
<!--                f = function () { n.parentNode.insertBefore(s, n); };-->
<!--            s.type = "text/javascript";-->
<!--            s.async = true;-->
<!--            s.src = "https://cdn.jsdelivr.net/npm/yandex-metrica-watch/tag.js";-->
<!---->
<!--            if (w.opera == "[object Opera]") {-->
<!--                d.addEventListener("DOMContentLoaded", f, false);-->
<!--            } else { f(); }-->
<!--        })(document, window, "yandex_metrika_callbacks2");-->
<!--    </script>-->
<!--    <noscript><div><img src="https://mc.yandex.ru/watch/47926829" style="position:absolute; left:-9999px;" alt="" /></div></noscript>-->
    <!-- /Yandex.Metrika counter -->
<?php } ?>
</head>
<body>
	<?php $this->beginBody() ?>

	<?php
	if(!empty(Yii::$app->user->id)){
		if(AuthAssignment::getRoleUserId(Yii::$app->user->id)[0] == 'client'){
			$extraClass = 'scrolling_menu';
		}else{
			$extraClass = '';
		}
	}else{
		$extraClass = '';
	}
	?>

	<div class="wrap">
		<div class="admin_main_menu <?= $extraClass ?>">
			<div class="admin_main_menu_flexing">
				<ul class="admin_sidebar_menu nav first_nav_margin <?= $demoClass ?>">
					<?php
//                    Yii::$app->cache->flush();
					if(Yii::$app->user->can('manageUsers')){

						$class = (Yii::$app->controller->id == 'site') ? 'active' : '';
						echo '<li class="'.$class.'">'.Html::a('<svg><use xlink:href="#left_2"></use></svg>'.Yii::t('blog', 'MAIN'),Url::to(['/site/admin'])).'</li>';

						echo '<li class="has_child"><span><svg><use xlink:href="#left_17"></use></svg>'.Yii::t('blog','CMS').'</span><ul class="admin_main_drop">';


						$class = (Yii::$app->controller->id == 'post' && Yii::$app->controller->module->id == 'blog') ? 'active' : '';
						echo '<li class="'.$class.'">'.Html::a(Yii::t('blog', 'POSTS'),Url::to(['/blog/post'])).'</li>';

						$class = (Yii::$app->controller->id == 'stakeholder' && Yii::$app->controller->module->id == 'stakeholder') ? 'active' : '';
						echo '<li class="'.$class.'">'.Html::a(Yii::t('blog', 'STAKEHOLDERS'),Url::to(['/blog/stakeholder'])).'</li>';

						$class = (Yii::$app->controller->id == 'category' && Yii::$app->controller->module->id == 'blog') ? 'active' : '';
						echo '<li class="'.$class.'">'.Html::a(Yii::t('blog', 'CATEGORIES'),Url::to(['/blog/category'])).'</li>';

						$class = (Yii::$app->controller->id == 'group' && Yii::$app->controller->module->id == 'blog') ? 'active' : '';
						echo '<li class="'.$class.'">'.Html::a(Yii::t('blog', 'GROUPS'),Url::to(['/blog/group'])).'</li>';

                        $class = (Yii::$app->controller->id == 'event' && Yii::$app->controller->module->id == 'blog') ? 'active' : '';
                        echo '<li class="'.$class.'">'.Html::a(Yii::t('blog', 'EVENTS'),Url::to(['/blog/event'])).'</li>';

						$class = (Yii::$app->controller->id == 'form' && Yii::$app->controller->module->id == 'forms') ? 'active' : '';
						echo '<li class="'.$class.'">'.Html::a(Yii::t('plugins', 'FORMS'),Url::to(['/forms/form'])).'</li>';

						$class = (Yii::$app->controller->id == 'formchain' && Yii::$app->controller->module->id == 'forms') ? 'active' : '';
						echo '<li class="'.$class.'">'.Html::a(Yii::t('forms', 'FORMCHAINS'),Url::to(['/forms/formchain'])).'</li>';

						$class = (Yii::$app->controller->module->id == 'plugins' && (Yii::$app->controller->id == 'plugin' || Yii::$app->controller->id == 'event' || Yii::$app->controller->id == 'shortcode')) ? 'active' : '';
						echo '<li class="'.$class.'">'.Html::a(Yii::t('plugins', 'PLUGINS'),Url::to(['/plugins/plugin'])).'</li>';

						$class = (Yii::$app->controller->id == 'autolinker' && Yii::$app->controller->module->id == 'plugins') ? 'active' : '';
						echo '<li class="'.$class.'">'.Html::a(Yii::t('blog', 'AUTO LINKER'),Url::to(['/plugins/autolinker'])).'</li>';

						$class = (Yii::$app->controller->id == 'contacts' && Yii::$app->controller->module->id == 'blog') ? 'active' : '';
						echo '<li class="'.$class.'">'.Html::a(Yii::t('blog', 'CONTACTS'),Url::to(['/blog/contacts'])).'</li>';

						$class = (Yii::$app->controller->id == 'manager') ? 'active' : '';
						echo '<li class="'.$class.'">'.Html::a(Yii::t('blog', 'MEDIA'),Url::to(['/imagemanager'])).'</li>';

						$class = (Yii::$app->controller->id == 'settings' && Yii::$app->controller->module->id == 'settings') ? 'active' : '';
						echo '<li class="'.$class.'">'.Html::a(Yii::t('blog', 'SETTINGS'),Url::to(['/settings/settings'])).'</li>';

						$class = (Yii::$app->controller->id == 'redirects') ? 'active' : '';
						echo '<li class="'.$class.'">'.Html::a(Yii::t('blog', 'REDIRECTS'),Url::to(['/redirects'])).'</li>';

						echo '</ul></li>';

						echo '<li class="has_child"><span><svg><use xlink:href="#left_16"></use></svg>'.Yii::t('blog','SETTINGS').'</span><ul class="admin_main_drop">';

						$class = (Yii::$app->controller->action->id == 'index' && Yii::$app->controller->module->id == 'user') ? 'active' : '';
						echo '<li class="'.$class.'">'.Html::a(Yii::t('user', 'USERS'),Url::to(['/user/default'])).'</li>';

						$class = (Yii::$app->controller->action->id == 'seo-club-requests' && Yii::$app->controller->module->id == 'user') ? 'active' : '';
						echo '<li class="'.$class.'">'.Html::a(Yii::t('user', 'SEO_CLUB_REQUESTS'),Url::to(['/user/default/seo-club-requests'])).'</li>';

						$class = (Yii::$app->controller->id == 'default' && Yii::$app->controller->module->id == 'translation') ? 'active' : '';
						echo '<li class="'.$class.'">'.Html::a(Yii::t('blog', 'TRANSLATIONS'),Url::to(['/translation/default'])).'</li>';

						$class = (Yii::$app->controller->id == 'letter' && Yii::$app->controller->module->id == 'letter') ? 'active' : '';
						echo '<li class="'.$class.'">'.Html::a(Yii::t('blog', 'LETTERS'),Url::to(['/letter/letter'])).'</li>';

						$class = (Yii::$app->controller->id == 'reports' && Yii::$app->controller->module->id == 'user') ? 'active' : '';
						echo '<li class="'.$class.'">'.Html::a(Yii::t('blog', 'REPORTS_ADMIN'),Url::to(['/user/reports'])).'</li>';

						$class = (Yii::$app->controller->id == 'user-token') ? 'active' : '';
						echo '<li class="'.$class.'">'.Html::a(Yii::t('blog', 'TOKENS'),Url::to(['/user/user-token'])).'</li>';

						echo '</ul></li>';

						echo '<li class="has_child"><span><svg><use xlink:href="#left_14"></use></svg>'.Yii::t('blog','CABINET').'</span><ul class="admin_main_drop">';

					}

					if(Yii::$app->user->can('clientActions')){
						$class = (
							Yii::$app->controller->id == 'cabinet' &&
							Yii::$app->controller->module->id == 'user' &&
							(Reports::getTypeIdByGet(Yii::$app->request->get()) == 1) || (Yii::$app->controller->action->id == 'blogs')) ? 'active' : '';
						echo '<li class="'.$class.'">'
						.Html::a('<svg><use xlink:href="#left_1"></use></svg>'.Yii::t('blog', 'CABINET_BLOGS'),Url::to(['/cabinet/blogs'])).'</li>';
					}

					if(Yii::$app->user->can('clientActions')){
						$class = (
							Yii::$app->controller->id == 'cabinet' &&
							Yii::$app->controller->module->id == 'user' &&
							(Reports::getTypeIdByGet(Yii::$app->request->get()) == 1) || (Yii::$app->controller->action->id == 'events')) ? 'active' : '';
						echo '<li class="'.$class.'">'
						.Html::a('<svg><use xlink:href="#left_1"></use></svg>'.Yii::t('blog', 'CABINET_EVENTS'),Url::to(['/cabinet/events'])).'</li>';
					}

					if(Yii::$app->user->can('clientActions')){
						$class = (
							Yii::$app->controller->id == 'cabinet' &&
							Yii::$app->controller->module->id == 'user' &&
							(Reports::getTypeIdByGet(Yii::$app->request->get()) == 1) || (Yii::$app->controller->action->id == 'contacts')) ? 'active' : '';
						echo '<li class="'.$class.'">'
						.Html::a('<svg><use xlink:href="#left_1"></use></svg>'.Yii::t('blog', 'CABINET_CONTACTS'),Url::to(['/cabinet/contacts'])).'</li>';
					}
					if(Yii::$app->user->can('clientActions')){
						$class = (Yii::$app->controller->id == 'profile' && (Yii::$app->controller->action->id == 'index' || Yii::$app->controller->action->id == 'settings')) ? 'active' : '';
						echo '<li class="'.$class.'">'.Html::a('<svg><use xlink:href="#left_11"></use></svg>'.Yii::t('blog', 'PROFILE'),Url::to(['/cabinet/profile'])).'</li>';
					}
//						if(Yii::$app->user->can('clientActions')){
//							$class = (Yii::$app->controller->id == 'cabinet' && Yii::$app->controller->action->id == 'index') ? 'active' : '';
//							echo '<li class="'.$class.'">'.Html::a('<svg><use xlink:href="#left_2"></use></svg>'.Yii::t('blog', 'MAIN'),Url::to(['/cabinet'])).'</li>';
//						}
						// if(Yii::$app->user->can('clientActions')){
						// 	$class = (Yii::$app->controller->id == 'cabinet' && Yii::$app->controller->module->id == 'user' && ((Reports::getTypeIdByGet(Yii::$app->request->get()) == 6) || (Yii::$app->controller->action->id == 'my-marketing-strategy'))) ? 'active' : '';
						// 	echo '<li class="'.$class.'">'.Html::a('<svg><use xlink:href="#left_12"></use></svg>'.Yii::t('blog', 'MY_MARKETING'),Url::to(['/cabinet/my-marketing-strategy'])).'</li>';
						// }
//						if(Yii::$app->user->can('clientActions')){
//							$class = (Yii::$app->controller->id == 'cabinet' && Yii::$app->controller->module->id == 'user' && (Reports::getTypeIdByGet(Yii::$app->request->get()) == 1) || (Yii::$app->controller->action->id == 'reports')) ? 'active' : '';
//							echo '<li class="'.$class.'">'.Html::a('<svg><use xlink:href="#left_1"></use></svg>'.Yii::t('blog', 'MARKETING_ANALITYC'),Url::to(['/cabinet/reports'])).'</li>';
//						}
//						if(Yii::$app->user->can('clientActions')){
//							$class = (Yii::$app->controller->id == 'cabinet' && Yii::$app->controller->module->id == 'user' && (Reports::getTypeIdByGet(Yii::$app->request->get()) == 2) || (Yii::$app->controller->action->id == 'industrial')) ? 'active' : '';
//							echo '<li class="'.$class.'">'.Html::a('<svg><use xlink:href="#left_5"></use></svg>'.Yii::t('blog', 'INDUSTRIAL_STATISTIC'),Url::to(['/cabinet/industrial'])).'</li>';
//						}
//						if(Yii::$app->user->can('clientActions')){
//							$class = (Yii::$app->controller->id == 'cabinet' && Yii::$app->controller->module->id == 'user' && (Reports::getTypeIdByGet(Yii::$app->request->get()) == 3) || (Yii::$app->controller->action->id == 'nps')) ? 'active' : '';
//							echo '<li class="'.$class.'">'.Html::a('<svg><use xlink:href="#left_4"></use></svg>'.Yii::t('blog', 'NPS'),Url::to(['/cabinet/nps'])).'</li>';
//						}
//						if(Yii::$app->user->can('clientActions')){
//							$class = (Yii::$app->controller->id == 'cabinet' && Yii::$app->controller->module->id == 'user' && (Reports::getTypeIdByGet(Yii::$app->request->get()) == 4) || (Yii::$app->controller->action->id == 'geomarketing')) ? 'active' : '';
//							echo '<li class="'.$class.'">'.Html::a('<svg><use xlink:href="#left_3"></use></svg>'.Yii::t('blog', 'GEOMARKETING'),Url::to(['/cabinet/geomarketing'])).'</li>';
//						}
//						if(Yii::$app->user->can('clientActions')){
//							$class = (Yii::$app->controller->id == 'cabinet' && Yii::$app->controller->module->id == 'user' && (Reports::getTypeIdByGet(Yii::$app->request->get()) == 5) || (Yii::$app->controller->action->id == 'manuals')) ? 'active' : '';
//							echo '<li class="'.$class.'">'.Html::a('<svg><use xlink:href="#left_8"></use></svg>'.Yii::t('blog', 'MANUALS'),Url::to(['/cabinet/manuals'])).'</li>';
//						}
//						if(Yii::$app->user->can('clientActions')){
//							$class = (Yii::$app->controller->id == 'cabinet' && Yii::$app->controller->action->id == 'market') ? 'active' : '';
//							echo '<li class="'.$class.'">'.Html::a('<svg><use xlink:href="#left_7"></use></svg>'.Yii::t('blog', 'GO_TO_MARKET'),Url::to(['/cabinet/market'])).'</li>';
//						}
//						if(Yii::$app->user->can('clientActions')){
//							$class = (Yii::$app->controller->action->id == 'lead-generation') ? 'active' : '';
//							echo '<li class="'.$class.'">'.Html::a('<svg><use xlink:href="#left_10"></use></svg>'.Yii::t('blog', 'LEAD_GENERATION'),Url::to(['/cabinet/lead-generation'])).'</li>';
//						}
//						if(Yii::$app->user->can('clientActions')){
//							$class = (Yii::$app->controller->action->id == 'transfer-pricing' || Reports::getTypeIdByGet(Yii::$app->request->get()) == 7 && Yii::$app->controller->id == 'cabinet') ? 'active' : '';
//							echo '<li class="'.$class.'">'.Html::a('<svg><use xlink:href="#left_18"></use></svg>'.Yii::t('blog', 'TRANSFER_PRICING'),Url::to(['/cabinet/transfer-pricing'])).'</li>';
//						}
//						if(Yii::$app->user->can('clientActions')){
//							$class = (Yii::$app->controller->action->id == 'documents' || Reports::getTypeIdByGet(Yii::$app->request->get()) == 8 && Yii::$app->controller->id == 'cabinet') ? 'active' : '';
//							echo '<li class="'.$class.'">'.Html::a('<svg><use xlink:href="#docs"></use></svg>'.Yii::t('blog', 'DOCUMENTS'),Url::to(['/cabinet/documents'])).'</li>';
//						}
//						if(Yii::$app->user->can('clientActions')){
//							$class = (Yii::$app->controller->id == 'partner-bonus') ? 'active' : '';
//							echo '<li class="'.$class.' no_border">'.Html::a('<svg><use xlink:href="#partner"></use></svg>'.Yii::t('blog', 'PARTNER'),Url::to(['/cabinet/partner-bonus'])).'</li>';
//						}


					if(Yii::$app->user->can('clientActions')){
						echo '<ul class="admin_sidebar_menu nav second_nav_margin">';
						if(!empty(Invitation::getUserTeams()) || Yii::$app->user->can('manageUsers')){
							$class = (Yii::$app->controller->id == 'default' && Yii::$app->controller->action->id == 'index' && Yii::$app->controller->module->id == 'team') ? 'active' : '';
							echo '<li class="'.$class.'">'.Html::a('<svg><use xlink:href="#left_9"></use></svg>'.Yii::t('blog', 'TEAM'),Url::to(['/cabinet/team'])).'</li>';
						}
//								if(Yii::$app->user->can('clientActions')){
//									$class = (Yii::$app->controller->id == 'profile' && (Yii::$app->controller->action->id == 'index' || Yii::$app->controller->action->id == 'settings')) ? 'active' : '';
//									echo '<li class="'.$class.'">'.Html::a('<svg><use xlink:href="#left_11"></use></svg>'.Yii::t('blog', 'PROFILE'),Url::to(['/cabinet/profile'])).'</li>';
//								}
							echo '</ul>';
						}
				?>
			</ul>
		</div>

		<div class="admin-navbar-logout">

			<div class="logo-ebrd">
				<a href="/" class="logo-ebrd__title">SAF</a>
			</div>

			<?php
			NavBar::begin([
				'options' => [
					'class' => 'admin_menu_wrap',
				],
			]);
			if (Yii::$app->user->isGuest) {
				$menuItems[] = '<li>'.Html::a(Yii::t('blog','LOGIN'),Url::to(['/login']),['class'=>'logout']).'</li>';
			} else {
				$menuItems[] = '<li>'
				. Html::beginForm(['/site/logout'], 'post')
				. Html::submitButton(
					Yii::t('blog','EXIT_DEMO_CABINET'),
					['class' => 'logout']
				)
				. Html::endForm()
				. '</li>';
			}

			echo  Nav::widget([
				'options' => ['class' => 'admin_controls_cabinet'],
				'items' => $menuItems,
			]);

			NavBar::end();
			?>

		</div>


</div>

<div class="container main_content">
			<div class="admin_bar">
				<?php if($isDemoSession){ ?>
					<div class="demo_container_user">
						<div class="demo_user_text">
							<?= Yii::t('blog','DEMO_USER_TEXT') ?>
						</div>
						<div class="demo_user_btn">
							<?= Html::a(Yii::t('blog','SIGN_UP_IT'),Url::to(['/signup'])) ?>
						</div>
					</div>
					<?php } ?>
					<div class="admin_bar_flexing">
						<a class="admin-btn-mobile" href="#"><i class="glyphicon glyphicon-menu-hamburger"></i></a>
				<!-- <ul class="admin_bar_quick_links">
					<li class="admin_bar_logo"><img src="/images/logo/admin_logo.svg"></li>
				</ul> -->

				<a href="/" class="logo-ebrd">
					<span class="logo-ebrd__title">SAF</span>
					<span class="logo-ebrd__subtitle">Sustainable Agribusiness Forum</span>
				</a>

				<div class="flex__aic">
<!-- 					<div class="chat-opener">
						<div class="flex">&<span>chat</span></div>
						<span class="chat-opener__count">n</span>
					</div> -->

					<?php
					NavBar::begin([
						'options' => [
							'class' => 'admin_menu_wrap',
						],
					]);
					?>
					<?php
					$menuItems = [];
					if (Yii::$app->user->isGuest) {
						$menuItems[] = '<li>'.Html::a(Yii::t('blog','LOGIN'),Url::to(['/login']),['class'=>'logout']).'</li>';
						$menuItems[] = '<ul class="admin_bar_language">'
						.LanguageSwitcher::widget([
							'options' => ['class' => 'align-middle ']
						])
						.'</ul>';
					} else {
						$menuItems[] = '<ul class="admin_bar_language">'
						.LanguageSwitcher::widget([
							'options' => ['simple' => true]
						])
						.'</ul>';
					}
					echo  Nav::widget([
						'options' => [
							'class' => 'admin_controls_cabinet'],
						'items' => $menuItems,
					]);

					NavBar::end();
					?>
				</div>

			</div>
		</div>
		<div class="main_body_content <?= $demoClass ?>">
			<?= BlogBreadcrumbs::widget([
				'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			]) ?>
			<?= Alert::widget() ?>
			<?php
			if(Yii::$app->user->can('translate')){
					//echo frontend\modules\blog\components\widgets\shortcodes_info\ShortcodesInfo::widget();
			}
			?>
			<?= $content ?>
		</div>

	</div>
<!-- <div class="chat">
	<div class="chat__box">
		<div class="chat__name">chat name</div>
		<div class="chat__close">X</div>
	</div>

	<div class="chat__container">

		<div class="chat__date">19.19.9999</div>

		<div class="chat-message">
			<div class="chat-message__avatar"></div>
			<div class="chat-message__box">
				<div class="chat-message__username">username</div>
				<div class="chat-message__usermessage">usermessage  </div>
			</div>
			<div class="chat-message__time">22:00</div>
		</div>

		<div class="chat-message">
			<div class="chat-message__avatar"></div>
			<div class="chat-message__box">
				<div class="chat-message__username">username</div>
				<div class="chat-message__usermessage">usermessage  </div>
			</div>
			<div class="chat-message__time">22:00</div>
		</div>

		<div class="chat-message">
			<div class="chat-message__avatar"></div>
			<div class="chat-message__box">
				<div class="chat-message__username">username</div>
				<div class="chat-message__usermessage">usermessage  </div>
			</div>
			<div class="chat-message__time">22:00</div>
		</div>

		<div class="chat-message">
			<div class="chat-message__avatar"></div>
			<div class="chat-message__box">
				<div class="chat-message__username">username</div>
				<div class="chat-message__usermessage">usermessage  </div>
			</div>
			<div class="chat-message__time">22:00</div>
		</div>

		<div class="chat-message">
			<div class="chat-message__avatar"></div>
			<div class="chat-message__box">
				<div class="chat-message__username">username</div>
				<div class="chat-message__usermessage">usermessage  </div>
			</div>
			<div class="chat-message__time">22:00</div>
		</div>

		<div class="chat-message">
			<div class="chat-message__avatar"></div>
			<div class="chat-message__box">
				<div class="chat-message__username">username</div>
				<div class="chat-message__usermessage">usermessage  </div>
			</div>
			<div class="chat-message__time">22:00</div>
		</div>

		<div class="chat-message">
			<div class="chat-message__avatar"></div>
			<div class="chat-message__box">
				<div class="chat-message__username">username</div>
				<div class="chat-message__usermessage">usermessage  </div>
			</div>
			<div class="chat-message__time">22:00</div>
		</div>

		<div class="chat-message">
			<div class="chat-message__avatar"></div>
			<div class="chat-message__box">
				<div class="chat-message__username">username</div>
				<div class="chat-message__usermessage">usermessage  </div>
			</div>
			<div class="chat-message__time">22:00</div>
		</div>

		<div class="chat-message">
			<div class="chat-message__avatar"></div>
			<div class="chat-message__box">
				<div class="chat-message__username">username</div>
				<div class="chat-message__usermessage">usermessage  </div>
			</div>
			<div class="chat-message__time">22:00</div>
		</div>

		<div class="chat-message">
			<div class="chat-message__avatar"></div>
			<div class="chat-message__box">
				<div class="chat-message__username">username</div>
				<div class="chat-message__usermessage">usermessage  </div>
			</div>
			<div class="chat-message__time">22:00</div>
		</div>

		<div class="chat-message chat-message__my">
			<div class="chat-message__avatar"></div>
			<div class="chat-message__box">
				<div class="chat-message__username">username</div>
				<div class="chat-message__usermessage">usermessage usermessage usermessage usermessage </div>
			</div>
			<div class="chat-message__time">22:00</div>
		</div>

	</div>

	<div class="chat-send">
		<div class="chat-send__attach">&</div>
		<input class="chat-send__message" type="text" placeholder="Enter something">
		<div class="chat-send__send">></div>
	</div>

</div> -->


<div class="myModalContainer" id="myModContId">
	<div class="cancel_container">
		<div class="myModal" id="customModal"></div>
		<div class="close_magick_cantainer">
			<svg><use xlink:href="#cancel_icon"></use></svg>
		</div>
	</div>
</div>

<?php if($url == 'cabinet'){ ?>
	<!-- Hubspot -->
	<script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/4009075.js"></script>
	<!-- End Hubspot -->
	<?php } ?>

	<?php $this->endBody() ?>
	<!-- Start intercom.io -->
	<script>
		window.intercomSettings = {
			app_id: "vs86fxur",
	name: '<?= Yii::$app->user->isGuest ? 'unknown user' : (Yii::$app->user->identity->profile->full_name ?? 'name unset') ?>', // Full name
	email: '<?= Yii::$app->user->isGuest ? 'unknown email' : Yii::$app->user->identity->email ?>', // Email address
	created_at: '<?= Yii::$app->user->isGuest ? 'unknown created_at' : Yii::$app->user->identity->created_at ?>' // Signup Date
};
</script>
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/vs86fxur';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
<!-- End intercom.io -->
</body>
</html>
<?php $this->endPage() ?>
