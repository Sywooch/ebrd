<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\plugins\models\PluginsAutolinkerGlobalSettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('plugins', 'AUTOLINKER GLOBAL SETINGS');
$this->params['breadcrumbs'][] = ['label' => 'Auto Linker', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plugins-autolinker-global-settings-index">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            'id',
            'setting_name',
            'setting_description',
            'settings_value',
            //'updated_at',
            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update} {create}',
				'buttons'  => [
					'update' => function ($url, $model) {
						$url = Url::to(['/plugins/autolinker/settings-update', 'id' => $model->id]);
						return Html::a('<span class="fa fa-wrench"></span>', $url, ['title' => 'update']);
					},
//					'create' => function ($url, $model) {
//						$url = Url::to(['/plugins/autolinker/_create_settings', 'id' => $model->id]);
//						return Html::a('<span class="fa fa-wrench"></span>', $url, ['title' => 'create']);
//					},
				],
			],
        ],
    ]); ?>
<?php Pjax::end(); ?>
	
	
</div>