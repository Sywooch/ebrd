<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\forms\models\FormChain */

$this->title = Yii::t('forms', 'Create Form Chain');
$this->params['breadcrumbs'][] = ['label' => Yii::t('forms', 'Form Chains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-chain-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
