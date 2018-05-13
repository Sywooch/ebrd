<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use frontend\models\HdbkLanguage;
//use frontend\modules\blog\models\BlogPost;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogPost */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'POSTS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->menu_section;

foreach ($translationBtns as $key => $val){
	if($key !== $model->lang->code){
		echo Html::a('<span class="glyphicon glyphicon-pencil" style="padding-right:5px;"></span>'.Yii::t('blog', HdbkLanguage::getLanguageByCode($key)->name), ['view?id='.$val], ['class' => 'btn btn-primary','style' => 'margin-right:5px;']);
	}
}

foreach ($emptyColTranslationArray as $emptyColTranslationBtn){
	if($emptyColTranslationBtn !== 'alias'){
		echo Html::a('<span class="glyphicon glyphicon-plus" style="padding-right:5px;"></span>'.Yii::t('blog', HdbkLanguage::getLanguageByCode($emptyColTranslationBtn)->name), ['create-translation?id='.$model->id.'&translate_to='.$emptyColTranslationBtn], ['class' => 'btn btn-success','style' => 'margin-right:5px;']);
	}
}

?>
<div class="blog-post-view">

    <h1><?= Html::encode($model->name) ?></h1>

    <p>
		<?= Html::a(Yii::t('blog', 'VIEW'), Url::to(['/blog/post/front-view', 'id' => $model->id]), ['target' => '_blank','class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('blog', 'EDIT'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('blog', 'DELETE'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('blog', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
	
	
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'alias',
            'name',
			'description',
			[
				'label' => Yii::t('blog', 'LANGUAGE'),
				'value' => $model->lang->name
			],
            [
				'label' => Yii::t('blog', 'MAIN_CATEGORY'),
				'value' => $model->category->name
			],
            'author_id',
            'favorites',
			'published_at',
            'created_at',
            'updated_at',
			'content',
        ],
    ]) ?>
</div>
