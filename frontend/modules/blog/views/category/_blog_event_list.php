<?php
use yii\helpers\Url;
?>

<div class="event-item__container">
    <div class="event-item__image" style="background-image:url(<?=Yii::$app->imagemanager->getImagePath($model->picture,320,240,'inset')?>);">
        <div class="event-item__title"><?= $model->title ?></div>
    </div>
    <div class="event-item__content">

        <div class="event-item__box">
            <span class="event-item__label"><?= Yii::t('blog', 'EVENT_DATE') ?>:</span>
            <span class="event-item__text"><?=date('d', strtotime($model->date_begin)).'-'.date('d.m.Y', strtotime($model->date_end)) ?></span>
        </div>

        <div class="event-item__box2">
            <span class="event-item__label"><?= Yii::t('blog', 'EVENT_PLACE') ?>:</span>
            <span class="event-item__text"><?= $model->city ?></span>
        </div>

    </div>
    <a href="<?= Url::to(['/blog/event/front-view', 'id' => $model->id]) ?>" class="event-item__button button">
        <?= Yii::t('blog', 'EVENT_DETAILS')?>
    </a>
</div>
