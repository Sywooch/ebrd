<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\plugins\models\Event */

$this->title = Yii::t('plugins', 'CREATE EVENT');
$this->params['breadcrumbs'][] = ['label' => Yii::t('plugins', 'EVENTS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
