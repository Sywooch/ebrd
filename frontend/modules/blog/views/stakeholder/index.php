<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use frontend\modules\blog\models\BlogCategory;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\blog\models\SearchBlogStakeholder */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blog Stakeholders';
$this->params['breadcrumbs'][] = $this->title;
$lang = Yii::$app->language;
$groups = [];
if($lang == 'en') {
	$groups = ArrayHelper::map(BlogCategory::find()->where(['parent_category_id' => BlogCategory::find()->select('id')->where('name like "%Stakeholders%"')->one()])->asArray()->all(), 'id', 'name');
} 
else if($lang == 'uk') {
	$groups = ArrayHelper::map(BlogCategory::find()->where(['parent_category_id' => BlogCategory::find()->select('id')->where('name like "%Зацікавлені сторони%"')->one()])->asArray()->all(), 'id', 'name');
}
?>
<div class="blog-stakeholder-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Blog Stakeholder', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'mail',
            'phone',
			[
				'label' => Yii::t('blog', 'STAKEHOLDER_GROUP'),
				'value' => function ($model) {
					$category = BlogCategory::findOne($model->group_id);
					return $category->name;
				},
				'format' => 'raw',
				'filter' => Html::activeDropDownList($searchModel, 'group_id', $groups, ['prompt' => 'All', 'class' => 'form-control'])
			],
            'location',
            'description:ntext',
            [
				'class' => 'yii\grid\ActionColumn',
				'header' => Yii::t('blog', 'ACTION')
			],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
