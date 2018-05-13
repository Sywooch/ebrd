<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogEvent */

$this->title = Yii::t('blog', 'CREATE_BLOG_EVENT');
$this->params['breadcrumbs'][] = ['label' => 'Blog Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-event-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'languages' => $languages,
        'stakeholders' => $stakeholders
    ]) ?>

</div>
