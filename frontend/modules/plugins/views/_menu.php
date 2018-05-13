<?php

use yii\bootstrap\Nav;

frontend\modules\user\bundles\UserModuleAsset::register($this);

echo Nav::widget([
    'options' => [
        'class' => 'nav-tabs',
        'style' => 'margin-bottom: 15px'
    ],
    'items' => [
        [
            'label' => Yii::t('plugins', 'ITEMS'),
            'url' => ['/plugins/plugin/index'],
        ],
        [
            'label' => Yii::t('plugins', 'EVENTS'),
            'url' => ['/plugins/event/index'],
        ],
        [
            'label' => Yii::t('plugins', 'SHORTCODES'),
            'url' => ['/plugins/shortcode/index'],
        ],
        [
            'label' => Yii::t('plugins', 'INSTALL'),
            'url' => ['/plugins/plugin/install'],
        ],
    ]
]);
