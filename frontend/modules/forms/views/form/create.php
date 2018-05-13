<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\forms\models\Form */

$this->title = Yii::t('forms', 'Create Form');
$this->params['breadcrumbs'][] = ['label' => Yii::t('forms', 'Forms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
