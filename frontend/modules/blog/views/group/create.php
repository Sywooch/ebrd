<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogGroup */
/* @var $languages array */

$this->title = Yii::t('app', 'Create Blog Group');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'items' => $items,
    ]) ?>

</div>
