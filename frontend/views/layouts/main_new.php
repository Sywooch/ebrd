<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\modules\blog\models\SearchForm;
use frontend\modules\blog\components\widgets\lang_switcher\LanguageSwitcher;
use frontend\modules\blog\components\widgets\grouped_menu\BlogGroupedMenu;
use frontend\components\widgets\share_btns\ShareButtons;
use frontend\components\widgets\alt_lang\AltLang;
use frontend\modules\plugins\shortcodes\content\singlecontactphone\SinglecontactphoneWidget;

AppAsset::register($this);

$lastMenuUpdate = [
	'class' => 'yii\caching\DbDependency',
	'sql' => 'SELECT MAX(up) FROM (SELECT MAX(updated_at) up FROM blog_category UNION SELECT MAX(updated_at) up FROM blog_group) AS test;',
	'reusable' => true,
];

$model = new SearchForm();
?>
<?php $this->beginPage();
yii::$app->cache->flush();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <?= AltLang::widget() ?>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) .' ‐ '. Yii::$app->name ?></title>
	<meta name="theme-color" content="#ac162c">
<!--	<meta property="og:title" content="--><?php //echo Html::encode($this->title) .' ‐ '. Yii::$app->name ?><!--" />-->
<!--	<meta property="og:type" content="website" />-->
<!--	<meta property="og:url" content="--><?php //echo $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?><!--" />-->
<!--	<meta property="og:image:width" content="250" />-->
<!--	<meta property="og:image:height" content="250" />-->
<!--	<meta property="fb:app_id" content="349526765459603" />-->
<!--	<meta property="og:site_name" content="--><?php //echo Yii::t('settings', 'UBP') ?><!--" />-->
    <?php $this->head() ?>
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
</head>
<body>
	<?php $this->beginBody() ?>
<script type="application/ld+json">
{
	"@context": "http://schema.org",
	"@type": "Organization",
	"url": "<?= $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'] ?>",
	"logo": "<?= $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'] . '/images/logo/logo.svg' ?>"
}
</script>
<script type="application/ld+json">
{
	"@context" : "http://schema.org",
	"@type" : "Organization",
	"name" : "<?= Yii::$app->name ?>",
	"url" : "<?= $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'] ?>",
	"sameAs" : [
	  "https://www.facebook.com/ubp.org.ua/",
	  "https://www.youtube.com/channel/UC7mpOXonmHTV4yaNZyAMgpg"
	]
}
</script>
<div class="hide" itemscope itemtype="http://schema.org/Organization">
	<span itemprop="name"><?= Yii::$app->name ?></span>
	<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
		<span itemprop="streetAddress"></span>
		<span itemprop="postalCode"></span>
		<span itemprop="addressLocality"></span>
	</div>
	<span itemprop="telephone"></span>
	<span itemprop="email"></span>
</div>
<div id="top_scroll"></div>
<?php if(!Yii::$app->user->getIsGuest()){ ?>
<div class="admin_menu_fix">
    <div class="admin_menu_controls">
        <div class="site_name_admin">
            <a rel="nofollow" href="/site/admin/" target="_blank"><?= Yii::$app->name ?></a>
        </div>
        <div class="update_admin_btn">
			<?php
				if(!empty($this->context->actionParams['id'])){
					echo Html::tag('a', Html::encode(Yii::t('blog', 'EDIT_PAGE')), ['rel' => 'nofollow', 'target' => '_blank','href' => '/'.$this->context->module->id.'/'.$this->context->id.'/update?id='.$this->context->actionParams['id']]);
				}
			?>
        </div>
    </div>
    <div class="main_menu_logout">
        <?php
            $menuItems[] = '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    Yii::t('blog','LOGOUT'),
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>';
            echo Nav::widget([
                'options' => ['class' => 'admin_menu_logout'],
                'items' => $menuItems,
            ]);
        ?>
    </div>
</div>
<?php } ?>

<div class="pre_main_menu">
	<div class="pre_main_menu_container">
		<div class="controls_pre_main_menu">
			<div class="controls_pre_main_menu_flexing">
				<a href="/" class="logo-ebrd">
					<span class="logo-ebrd__title">UBP</span>
					<span class="logo-ebrd__subtitle">Ukraine Biomass Program</span>
				</a>
				<div class="btn-mobile_container">
					<a href="#" class="btn-mobile">
						<span class="super_hamburger_1"></span>
						<span class="super_hamburger_2"></span>
						<span class="super_hamburger_3"></span>
					</a>
				</div>
			</div>

			<div class="controls_pre_main_menu_flexing">
				<div class="toggle_glass_container">
					<div id="form_search">
						<?php $form = ActiveForm::begin([
							'action' => ['/blog/search/search'],
							'method' => 'GET',
							'options' => [
								'class' => 'js_submitting'
							],
						]);
						?>
						<?= $form->field($model, 'q')->textInput(['class' => 'input'])->label('')?>

						<?php ActiveForm::end(); ?>
					</div>
					<div class="btn_glass">
						<svg><use xlink:href="#s_glass_icon"></use></svg>
					</div>
				</div>
				<div class="socials_pre_main_menu">
					<?php
					if(Yii::$app->user->getIsGuest()){
						echo Html::a(Yii::t('blog', 'LOGIN_MY_CABINET'), Url::to(['/cabinet']), ['class' => 'button', 'rel' => 'nofollow']);
					}else{
						echo Html::a(Yii::t('blog', 'CABINET'), Url::to(['/cabinet']), ['class' => 'button', 'rel' => 'nofollow']);
					}
					?>
				</div>
				<div class="lang_switch_container">
					<?php
					echo LanguageSwitcher::widget([
						'options' => [
//							        'class' => 'my_custom_lang_switch',
							'simple' => true
						]
					]);
					?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="wrap">
    <div class="main_menu_s">
        <div class="main_menu_s_container">
            <div class="menu_controls_container">
                <div class="lang_switch_container">
                    <div class="dropdown my_custom_lang_switch">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Ukrainian
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" id="main_ls">
                            <li class="lang_inac"><a href="/industries">English</a></li>
                        </ul>
                    </div>
                </div>
				<div class="main_menu_container_list">
					<?php
						preg_match('/^(?:\/uk)?\/([A-z-]+)\/?/', Yii::$app->request->url, $maches); 		//
						if (!isset($maches[1])){$maches[1] = 'main';}										//
						if ($this->beginCache('topMenu',[
							'duration' => 7*24*60*60,
							'variations' => [$maches[1],Yii::$app->language],								//
							'dependency' => $lastMenuUpdate
						])){
					?>
						<?= BlogGroupedMenu::widget()?>
					<?php

							$this->endCache();
						}
					?>
				</div>
            </div>
        </div>
    </div>

<!--	<div class="page_container">-->

        <?= Alert::widget() ?>

        <?=$content?>
    <!--</div>-->
</div>

<footer class="footer_custom">
	<div class="footer_custom_container">

		<div class="footer_ins_col">
			<div class="images_footer_col_line">
				<img src="/images/company_logos/gef.png">
				<img src="/images/company_logos/eb.png">
				<img src="/images/company_logos/ec.png">
			</div>
		</div>

		<div class="footer_ins">
			<?php
			if ($this->beginCache('footerLinks', [
				'duration' => 7*24*60*60,
				'variations' => [Yii::$app->language],
				'dependency' => $lastMenuUpdate	])
		){
			?>
			<div class="footer_ins_col">
				<?php
				$menuFooterItems = BlogGroupedMenu::getMultilangFooterStructure(Yii::$app->language);
				echo Nav::widget([
					'options' => ['class' => 'my_crutch'],
					'items' => $menuFooterItems,
				]);
				?>
			</div>
			<?php
			$this->endCache();}
			?>
		</div>
		<div class="copyright">
			<div class="copyright__container">
				<a href="/" class="copyright__logo"><img src="/images/logo/ebrd_logo.png"></a>
				<div class="copyright_col">
					<?php
					echo Yii::t('blog', 'ALL_RIGHTS_RESERVED') .'. UBP '. date('Y');
					?>
				</div>
				<div class="copyright_col copyright_col_mob">
					<?php
//					echo Html::tag('a', Html::encode(Yii::t('blog', 'PRIVACY_POLICY')), ['href' => '/download/privacy_policy_'.Yii::$app->language.'.pdf','target' => '_blank']);
					?>
				</div>
			</div>

			<div class="copyright__container">
				<div class="developers">Developed in <a class="developers__link" href="https://aimarketing.info/uk">AIM</a></div>
			</div>
		</div>
	</div>
</footer>

<div class="myModalContainer" id="myModContId">
    <div class="cancel_container">
    <div class="myModal" id="customModal"></div>
    <div class="close_magick_cantainer">
        <svg><use xlink:href="#cancel_icon"></use></svg>
    </div>
    </div>
</div>
<div class="scrolling_btns">
	<div class="scrolling_top">
		<a class="scrolling" href="#top_scroll"><span class="glyphicon glyphicon-menu-up"></span></a>
	</div>
	<div class="scrolling_bottom">
		<a class="scrolling" href="#bottom_scroll"><span class="glyphicon glyphicon-menu-down"></span></a>
	</div>
</div>

<div id="bottom_scroll"></div>
<!-- Start of HubSpot Embed Code -->
  <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/4009075.js"></script>
<!-- End of HubSpot Embed Code -->
<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
