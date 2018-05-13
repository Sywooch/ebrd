<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\blog\models\SearchForm;
$model = new SearchForm();
$this->title = '510';
?>
<main class="main-404-content main-500-content">
    <div class="shadow-overlay"></div>
    <div class="container_wrap">
        <div class="page_not_found_wrap">
            <h1>Didn't appear where expected?</h1>
            <p>Sorry...<span>It's not you.</span><span>It's us.</span></p>
            <div class="not_found_search">
                <p>Perhaps searching will help:</p>
                <?php $form = ActiveForm::begin([
                    'id' => '403_search',
                    'action' => ['/blog/search/search'],
                    'method' => 'GET'
                ]);
                ?>
                <div class="form_search_wrap">
                    <?= $form->field($model, 'q')->textInput(['class' => 'input', 'placeholder' => Yii::t('blog', 'SEARCH')])->label('')?>
                    <?php echo Html::submitButton('<svg><use xlink:href="#s_glass_icon"></use></svg>', ['class' => 'search_btn_f'] )?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="not_found_error">
                <p>510<span>Error. Not Extended</span></p>
            </div>
        </div>
    </div>
</main>