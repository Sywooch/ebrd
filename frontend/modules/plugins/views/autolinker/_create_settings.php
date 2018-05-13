<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\plugins\models\PluginsAutolinker */

$this->title = Yii::t('app', 'Create Plugins Autolinker');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Plugins Autolinkers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plugins-autolinker-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_create_settings', [
        'model' => $model,
    ]) ?>

</div>
