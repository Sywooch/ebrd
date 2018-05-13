<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lo\plugins\models\Plugin */

$this->title = Yii::t('plugins', 'CREATE ITEM');
$this->params['breadcrumbs'][] = ['label' => Yii::t('plugins', 'ITEMS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
