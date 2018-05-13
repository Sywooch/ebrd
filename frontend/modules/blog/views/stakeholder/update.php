<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogStakeholder */

$this->title = Yii::t('blog', 'Update Blog Stakeholder: {stakeholderName}', [
	'stakeholderName' => $model->name
]);

$this->params['breadcrumbs'][] = ['label' => 'Blog Stakeholders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="blog-stakeholder-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
