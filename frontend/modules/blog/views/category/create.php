<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogCategory */

$this->title = Yii::t('blog', 'CREATE_CATEGORY');
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'CATEGORIES'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'items' => $items,
        'parent' => $parent,
        'groups' => $groups,
		'layouts' => $layouts,
    ]) ?>

</div>
