<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use common\models\Invitation;
use \frontend\modules\blog\models\BlogEventStatus;
use \yii\helpers\ArrayHelper;

$this->title = Yii::t('blog', 'CABINET_EVENTS');
?>

<div class="main_cabinet_wrap">

    <?php Pjax::begin(); ?>

    <div class="cabinet-search-container">
        <p class="cabinet-title"><?= Html::encode($this->title) ?></p>
        <span class="cabinet-search"><?php echo $this->render('_event_search', ['model' => $searchModel]); ?></span>
    </div>

    <div class="cabinet-posts">
        <?= GridView ::widget([
            'dataProvider' => $dataProvider,
            'summary' => false,
//            'filterModel' => $searchModel,
            'tableOptions' => [
                'class' => 'cabinet-posts-table'
            ],
            'columns' => [
                [
                    'attribute' => 'date',
                    'label' => Yii::t('blog', 'TIME_OF_THE_EVENT'),
                    'value' => function ($model) {
                        return date('d.m.Y', strtotime($model->date_begin)) .' - '. date('d.m.Y', strtotime($model->date_end));
                    }
                ],
                [
                    'attribute' => 'title',
                ],
                [
                    'attribute' => 'status',
                    'sortLinkOptions' =>  ArrayHelper::map(BlogEventStatus::find()->all(), 'id', 'name'),
                    'content' => function ($model) {
                        $event_is_over = strtotime($model->date_end) < time();
                        if ($event_is_over){
                            $class = 'class="cabinet-posts__over flex__aic flex__jcc"';
                            $data = '<svg><use xlink:href="#svg_timer"></use></svg>'.Yii::t('blog', 'EVENT_IS_OVER');
                        } else{
                            $class = 'class="cabinet-posts__confirmed flex__aic flex__jcc"';
                            $data = '<svg><use xlink:href="#svg_check"></use></svg>'.Yii::t('blog', 'EVENT_CONFIRMED');
                        }
                        $html = "<div {$class}>{$data}</div>";
                        return $html;
                    },
                ],
            ],
        ] ); ?>
    </div>
    <?php Pjax::end(); ?>
</div>
