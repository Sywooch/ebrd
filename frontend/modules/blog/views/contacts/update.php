<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogContactOffice */

$this->title = Yii::t('blog', 'Update {modelClass}: ', [
    'modelClass' => 'Contact Office',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'Blog Contact Offices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('blog', 'Update');
?>
<div class="blog-contact-office-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
