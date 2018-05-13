<?php

/* @var $this yii\web\View */
/* @var $model frontend\modules\plugins\models\Shortcode */

$this->title = Yii::t('blog', 'UPDATE {modelClass}: ', [
    'modelClass' => Yii::t('blog', 'PHONE'),
]) . ' ' . $model->phone_number;
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'PHONE_NUMBER'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->phone_number, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('plugins', 'UPDATE');
?>
<div class="shortcode-update">

    <?= $this->render('_phones_form', [
        'model' => $model,
    ]) ?>

</div>