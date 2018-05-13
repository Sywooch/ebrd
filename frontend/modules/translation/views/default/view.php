<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\translation\models\SourceMessage */

$this->title = $model->message;
$this->params['breadcrumbs'][] = ['label' => Yii::t('translation', 'TRANSLATIONS_MANAGER'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="source-message-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category',
            'message:ntext',
            [
                'attribute' => 'translation',
                'format' => 'raw',
                'label' => Yii::t('translation', 'TRANSLATION'),
                'value' => function() use ($messages) {
                    $text = "";
                    foreach ($messages as $translation) {
                        $text .= $translation->language . ": " . $translation->translation . Html::tag('br');
                    }
                    return $text;
                }
            ],
        ],
    ]) ?>

</div>