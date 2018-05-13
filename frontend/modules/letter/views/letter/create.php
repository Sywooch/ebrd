<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\letter\models\Letter */
/* @var $translate */
/* @var $oldModel */
/* @var $items */
/* @var $translateRow */
/* @var $currLang */

$this->title = 'Create Letter';
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'LETTERS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="letter-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($translate) : ?>
    <?= $this->render('_form', [
        'model' => $oldModel,
        'items' => $items,
        'translateRow' => $translateRow,
        'oldModel' => $oldModel,
        'translate' => $translate,
        'disabled' => true
    ]) ?>
    <?php endif; ?>

    <?= $this->render('_form', [
        'model' => $model,
        'items' => $translate ? $currLang : $items,
        'translateRow' => $translateRow,
        'oldModel' => $oldModel,
        'translate' => $translate,
        'disabled' => false
    ]) ?>

</div>
