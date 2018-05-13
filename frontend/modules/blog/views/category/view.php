<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use frontend\models\HdbkLanguage;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogCategory */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'CATEGORIES'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->menu_section;

if($model->parent_category_id !== 0){
	foreach ($translationBtns as $key => $val){
		if($key !== $model->lang->code){
			echo Html::a('<span class="glyphicon glyphicon-pencil" style="padding-right:5px;"></span>'.Yii::t('blog', HdbkLanguage::getLanguageByCode($key)->name), ['view?id='.$val], ['class' => 'btn btn-primary','style' => 'margin-right:5px;']);
		}
	}

	foreach ($emptyColTranslationArray as $emptyColTranslationBtn){
		if($emptyColTranslationBtn !== 'alias'){
			$text = '<span class="glyphicon glyphicon-plus" style="padding-right:5px;"></span>'.Yii::t('blog',	HdbkLanguage::getLanguageByCode($emptyColTranslationBtn)->name);
			$url = ['create-translation?id='.$model->id.'&translate_to='.$emptyColTranslationBtn];
			$options = ['class' => 'btn btn-success','style' => 'margin-right:5px;'];
			echo Html::a($text, $url, $options);
		}
	}
}
?>
<div class="blog-category-view">

    <h1><?= Html::encode($model->name) ?></h1>

    <p>
		<?php 
			if($model->parent_category_id !== 0){
				echo Html::a(Yii::t('blog', 'VIEW'), Url::to(['/blog/category/front-view', 'id' => $model->id]), ['target' => '_blank','class' => 'btn btn-success']);
				echo Html::a(Yii::t('blog', 'EDIT'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
			}
		?>
        <?= (($model->parent_category_id === 0) || ($model->hasSubitems())) ? '' : Html::a(Yii::t('blog', 'DELETE'), ['delete', 'id' => $model->id], [
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
			'menu_section',
			'title',
			'description',
			[
				'label' => Yii::t('blog', 'LANGUAGE'),
				'value' => $model->lang->name
			],
			[
				'label' => Yii::t('blog', 'PARENT_CATEGORY'),
				'value' => function ($model){
					return (!empty($model->parent->name)) ? $model->parent->name : '';
				}
				
			],
			[
				'label' => Yii::t('blog', 'CATEGORY_GROUP'),
				'value' =>	function ($model){ 
								return (!empty($model->group->name)) ? $model->group->name : '';
							}
			],
            'created_at',
            'updated_at',
			'last_news',
			'content',
        ],
    ]) ?>

</div>
