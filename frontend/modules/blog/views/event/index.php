<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\blog\models\BlogEventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blog Events';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="blog-event-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Blog Event', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'alias',
                'label' => Yii::t('blog', 'ALIAS'),
            ],
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'stakeholder_id',
                'label' => Yii::t('blog', 'STAKEHOLDER'),
                'value' => function ($model) {
                    return $model->stakeholder->name;
                }
            ],
            [
                'attribute' => 'lang_id',
                'label' => Yii::t('blog', 'LANGUAGE'),
                'value' => function ($model) {
                    return $model->lang->name;
                }

            ],
            [
                'attribute' => 'title',
                'label' => Yii::t('blog', 'TITLE'),
                'value' => function ($model) {
                    return $model->stakeholder->name;
                }
            ],
            //'description:ntext',
            //'site_url:url',
            'place',
            'date_begin',
            'date_end',
            //'picture',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
