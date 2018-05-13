<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogPost */

$this->title = Yii::t('blog', 'TRANSLATE {modelClass}: ', [
    'modelClass' => 'Blog Post',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'Blog Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('blog', 'TRANSLATE');
?>
<div class="blog-post-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_translate_form', [
        'model' => $model,
		'items' => $items,
		'parent' => $parent,
		'old_model' => $old_model,
    ]) ?>

</div>