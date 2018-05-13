<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\user\models\PartnerBonus */

$this->title = Yii::t('blog', 'Create Partner Bonus');
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog', 'Partner Bonuses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-bonus-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
