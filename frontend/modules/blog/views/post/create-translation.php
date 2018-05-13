<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogPost */

$this->title = Yii::t('blog', 'Create Translation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'POSTS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $old_model->name, 'url' => Url::to(['/blog/post/view', 'id' => $old_model->id])];
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'UPDATE'), 'url' => Url::to(['/blog/post/update', 'id' => $old_model->id])];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="blog-post-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_translate_form', [
        'model' => $model,
		'items' => $items,
		'parent' => $parent,
		'old_model' => $old_model,
		'translateRow' => $translateRow,
		'newLangCode' => $newLangCode,
		'categoryList' => $categoryList,
		'catFlag' => $catFlag,
		'authors' => $authors,
    ]) ?>

</div>
