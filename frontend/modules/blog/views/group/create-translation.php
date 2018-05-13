<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogPost */

$this->title = Yii::t('blog', 'Cleate Translation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'POSTS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="blog-post-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_translate_form', [
        'model' => $model,
		'items' => $items,
		'old_model' => $old_model,
		'translateRow' => $translateRow,
		'newLangCode' => $newLangCode,
    ]) ?>

</div>
