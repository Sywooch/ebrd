<?php

/* @var $this yii\web\View */
/* @var $model frontend\modules\plugins\models\Shortcode */

$this->title = Yii::t('plugins', 'UPDATE {modelClass}: ', [
    'modelClass' => 'Shortcode',
]) . ' ' . $model->tag;
$this->params['breadcrumbs'][] = ['label' => Yii::t('plugins', 'Shortcodes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('plugins', 'UPDATE');
?>
<div class="shortcode-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
