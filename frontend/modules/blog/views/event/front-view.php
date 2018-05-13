<?php

use yii\helpers\Url;
use frontend\modules\blog\components\widgets\auto_linker\Autolinker;
use frontend\modules\blog\components\widgets\blog_menu\BlogMenu;
use common\models\User;
use yii\helpers\Html;
use frontend\modules\blog\models\BlogCategory;
use frontend\components\widgets\share_btns_blog\ShareButtonsBlog;
use frontend\modules\blog\components\widgets\related_news\RelatedNews;
/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogPost */
frontend\modules\blog\bundles\EventCustom::register($this);
$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'];

if(!empty($model->thumbnail)){
    $this->registerMetaTag(['property' => 'og:image', 'content' => $url.Yii::$app->imagemanager->getImagePath($model->thumbnail)]);
}else{
    $this->registerMetaTag(['property' => 'og:image', 'content' => $url.'/images/logo/logo.png']);
}
//$description = empty($model->description) ? $model->title : $model->description;

//$this->registerMetaTag(['property' => 'og:description', 'content' => $description]);
//$this->registerMetaTag(['name' => 'description', 'content' => $description]);
$this->title = $model->title;
?>
<div class="event">

    <div class="event__container">

        <div class="event__box">

            <div class="breadcrumbs">
                <?= Html::a(Yii::t('blog','MAIN'), Url::to(['/']))
                .'<span> > </span>'
                .Html::a(Yii::t('blog','EVENTS'), Url::to(['/blog/events']))
                .'<span> > </span>'
                .'<span class="breadcrumbs__current">'.$model->name.'</span>' ?>
            </div>
            <h1 class="event__title"><?= $model->title ?></h1>

            <div class="event__date">
                <svg><use xlink:href="#svg_calendar"></use></svg>
                <div><?=date('d', strtotime($model->date_begin)).'-'.date('d.m.Y', strtotime($model->date_end)) ?></div>
            </div>

            <div class="event__place">
                <svg><use xlink:href="#svg_pin"></use></svg>
                <div><?= $model->place ?></div>
            </div>
        </div>

        <div class="event__image-container"><img class="event__image" src="<?= Yii::$app->imagemanager->getImagePath($model->picture,680,370,'inset')?>" alt=""></div>
    </div>

    <div class="event__content">
        <div class="event__stakeholder"><?= $model->stakeholder->name ?></div>
        <div class="event__text"><?= Autolinker::widget(['content' => $model->description]);?></div>
    </div>

    <div class="event__buttons">
        <a class="button" href="<?= $model->site_url?>"><?= Yii::t('blog', 'EVENT_SITE')?> </a>
        <button class="button button__white <?=$subscription?'disabled':''?>"data-id="<?= $model->id ?>" id="js-add-event-to-user" >
                <?php
                    if (!$subscription){
                        echo Yii::t('blog','ADD_EVENT_TO USER');
                    } else{
                        echo Yii::t('blog','EVENT_ALREADY_ADDED_TO_USER');
                    }
                ?>
        </button>
    </div>

</div>



