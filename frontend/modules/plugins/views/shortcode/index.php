<?php

error_reporting(E_ALL & ~E_NOTICE);
use frontend\modules\plugins\helpers\BS;
use frontend\modules\plugins\models\App;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;

frontend\modules\plugins\bundles\PluginsModuleAsset::register($this);
/**
 * @var $this yii\web\View
 * @var $searchModel frontend\modules\plugins\models\search\ShortcodeSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = Yii::t('plugins', 'Shortcodes');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="shortcode-index">

    <?= $this->render('/_menu') ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'app_id',
                'label' => Yii::t('plugins', 'APP'),
                'options' => ['style' => 'width: 25px; align: center;'],
                'value' => function ($model) {
                    return BS::appLabel($model->app_id);
                },
                'filter' => ArrayHelper::map(App::find()->orderBy('name')->all(), 'id', 'name'),
                'format' => "raw"
            ],
            'tag',
            'tooltip',
            [
                'attribute' => 'data',
                'value' => function ($model) {
                    return StringHelper::truncate($model->data, 60);
                },
            ],
            [
                'attribute' => 'status',
                'options' => ['style' => 'width: 75px; align: center;'],
                'value' => function ($model) {
                    return $model->status == $model::STATUS_ACTIVE ? BS::label('Enabled', BS::TYPE_SUCCESS) : BS::label('Disabled', BS::TYPE_DANGER);
                },
                'filter' => [
                    1 => Yii::t('plugins', 'ENABLED'),
                    0 => Yii::t('plugins', 'DISABLED')
                ],
                'format' => "raw"
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'options' => ['style' => 'width: 75px;'],
                'buttons' => [
                    'update' => function ($url) {
                        return Html::a(BS::icon('pencil'), $url, [
                            'class' => 'btn btn-xs btn-primary',
                            'title' => Yii::t('plugins', 'UPDATE'),
                        ]);
                    },
                    'delete' => function ($url) {
                        return Html::a(BS::icon('trash'), $url, [
                            'class' => 'btn btn-xs btn-danger',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('plugins', 'ARE YOU SURE TO DELETE THIS ITEM?'),
                            'title' => Yii::t('plugins', 'DELETE'),
                        ]);
                    },
                ]
            ],
        ],
    ]); ?>

</div>
