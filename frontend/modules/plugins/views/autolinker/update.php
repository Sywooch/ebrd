<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\plugins\models\PluginsAutolinker */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Plugins Autolinker',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Plugins Autolinkers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="plugins-autolinker-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
