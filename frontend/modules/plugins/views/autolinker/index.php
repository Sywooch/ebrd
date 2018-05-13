<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use rmrevin\yii\fontawesome\FA;
use frontend\modules\plugins\models\PluginsAutolinker;
use frontend\modules\plugins\models\PluginsAutolinkerGlobalSettings;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\plugins\models\PluginsAutolinkerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('plugins', 'AUTO_LINKER');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-post-index">
    <h1>
    <?php
    echo Html::encode($this->title) . ' - ';
    $value = PluginsAutolinkerGlobalSettings::findOne(['setting_name' => 'status'])->settings_value;
    if ($value <= 0) {
        echo Html::tag('span', Yii::t('plugins', "DISABLED"), ['class' => "text-danger"]);
        echo Html::a(Yii::t('plugins', 'ENABLE'),
            ['global-status-update', 'status' => PluginsAutolinker::STATUS_ENABLED],
            ['class' => 'btn btn-success']);
    } else if ($value > 0) {
        echo Html::tag('span', Yii::t('plugins', "ENABLED"), ['class' => "text-success"]);
        echo Html::a(Yii::t('plugins', 'DISABLE'),
            ['global-status-update', 'status' => PluginsAutolinker::STATUS_DISABLED],
            ['class' => 'btn btn-danger']);
    }?>
    </h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p class="my_grubber">
        <?= Html::a(Yii::t('plugins', 'CREATE_NEW_LINK'), ['create'], ['class' => 'btn btn-success']); ?>
        <?= Html::a(Yii::t('plugins', 'SETTINGS'), ['settings'], ['class' => 'btn btn-primary']); ?>
		<span class="main_search_class"><?= (Yii::$app->user->can('createItem')) ? Html::a(Yii::t('blog', 'SEARCH'), '#', ['class' => 'btn btn-warning blog_search_btn']) : ''?></span>
    </p>
	<div class="blog_search">
		<?= $this->render('_search', [
			'model' => $searchModel, 
			'languageSearch' => $languageSearch,
		]); ?>
	</div>
<?php Pjax::begin(); ?>    
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
		'layout'=>'<div class="grid_over_autolinker">{items}</div>{pager}',
        'columns' => [
            'id',
            'title',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {status_update} {update} {delete}',
                'header' => Yii::t('blog', 'ACTION'),
                'buttons'  => [
                    'view' => function($url, $model, $key) {
                        return Html::a(FA::i('eye'), $url, ['title' => 'view']);
                    },
                    'status_update' => function($url, $model, $key) {
                        if ($model->status == PluginsAutolinker::STATUS_ENABLED) {
                            $link = Html::a(FA::i('minus-square', ['class' => 'text-danger']),
                                ['status-update', 'id' => $model->id, 'status' => PluginsAutolinker::STATUS_DISABLED],
                                ['title' => Yii::t('plugins', "DISABLE")]);
                        } else {
                            $link = Html::a(FA::i('plus-square', ['class' => 'text-success']),
                                ['status-update', 'id' => $model->id, 'status' => PluginsAutolinker::STATUS_ENABLED],
                                ['title' => Yii::t('plugins', "ENABLE")]);
                        }
                        return $link;
                    },
                    'update' => function($url, $model, $key) {
                        return Html::a(FA::i('cog'), $url, ['title' => 'update']);
                    },
                    'delete' => function($url, $model, $key) {
                        return Html::a(FA::i('trash'), $url, ['title' => 'delete']);
                    },
                ],
            ],
            'keywords:ntext',
            'url:url',
            'links_quantity',
            'lang',
            'info:ntext',
            [
                'attribute' => 'status',
                'label' => Yii::t('blog', 'STATUS'),
                'value' => function($model){
                    if ($model->status > 0) {
                        return Yii::t('plugins', "ENABLED");
                    }

                    return Yii::t('plugins', 'DISABLED');
                }
            ],
            'target',
            'updated_at',
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>


