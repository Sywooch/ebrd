<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\blog\models\SearchForm;
$model = new SearchForm();
$this->title = '403';
?>
<main class="main-404-content">
    <div class="shadow-overlay"></div>
    <div class="container_wrap">
        <div class="page_not_found_wrap">
            <h1>Didn't appear where expected?</h1>
            <p>The page you are requesting, moved or deleted.<span>Please use the menu at the top of the site.</span></p>
            <div class="not_found_search">
				<p>Perhaps searching will help:</p>

					<?php $form = ActiveForm::begin([
							'id' => 'search_page',
							'action' => ['/blog/search/search'],
							'method' => 'GET'
						]);
					?>
                    <div class="form_search_wrap">
					<?= $form->field($model, 'q')->textInput(['class' => 'input', 'placeholder' => Yii::t('blog', 'SEARCH')])->label('')?>
					<?php echo Html::submitButton('<svg><use xlink:href="#s_glass_icon"></use></svg>', ['class' => 'search_btn_f'] )?>
                    </div>
					<?php ActiveForm::end(); ?>
					<span><span></span></span>

            </div>
            <div class="not_found_error">
                <p>403<span>Error. Forbidden</span></p>
            </div>
        </div>
    </div>
</main>