<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogStakeholder */

$this->title = 'Create Blog Stakeholder';
$this->params['breadcrumbs'][] = ['label' => 'Blog Stakeholders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-stakeholder-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
