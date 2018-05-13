<?php

use yii\helpers\Html;
use frontend\modules\blog\models\TestAnaliticsMind;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogCategory */

$this->title = Yii::t('blog', 'TEST_ANALYTIC_FINAL');
if(!empty(Yii::$app->request->get('userid'))) {
	$userid = Yii::$app->request->get('userid');
}
else {
	$userid = Yii::$app->user->id;
}

$testresult = $model;
$correctanswers = $testresult->getCorrectAnswers();
$mark = $testresult->getMark();
$percent = $correctanswers/9*100;

?>
<div class="test-finish__container">
	<div class="test-finish">
		<?php
		if($mark == 5) {
			echo '<p class="title-simple">'.Yii::t('blog', 'TEST_CONGRATULATION_TEXT').'</p>';
		}
		?>

		<div class="test-finish-circle">

			<div class="test-finish-circle__filler">
				<svg class="radial-progress" data-percentage="<?= $percent; ?>" viewBox="0 0 80 80">
					<circle class="incomplete" cx="40" cy="40" r="35"></circle>
					<circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 39.58406743523136;"></circle>
					<text class="percentage" x="50%" y="57%" transform="matrix(0, 1, -1, 0, 80, 0)">n %</text>
				</svg>
			</div>
			<div class="test-finish-circle__result">
				<p class="test-finish-circle__text">0</p>
			</div>

		</div>


	<div class="test-finish__block">
		<div class="test-finish__title flex flex__aic">
			<span><?= Yii::t('blog', 'TEST_ANALYTIC_FINISH_MARK') ?></span>
			<div class="test-finish__mark"><?= $mark?></div>
		</div>
		<div class="test-finish__info text flex flex__aic">
			<span><?= Yii::t('blog', 'TEST_ANALYTIC_FINISH_MARK2') ?></span>
			<div class="text text__c"><?= $correctanswers?> / 9</div>
		</div>
	</div>

	</div>
	<a id="test_finish_button" href="/blog/test-analitic/view-result?userid=<?=$userid?>" class="test-finish__button"><?= Yii::t('blog', 'TEST_ANALYTIC_FINISH_BUTTON') ?></a>
</div>
</div>
<?php
$js = <<<JS

$(document).ready(function() {

$('svg.radial-progress').each(function( index, value ) {
  $(this).find($('circle.complete')).removeAttr( 'style' );
});

$(window).scroll(function(){
  $('svg.radial-progress').each(function( index, value ) {
    // If svg.radial-progress is approximately 25% vertically into the window when scrolling from the top or the bottom
    if (
        $(window).scrollTop() > $(this).offset().top - ($(window).height() * 0.75) &&
        $(window).scrollTop() < $(this).offset().top + $(this).height() - ($(window).height() * 0.25)
    ) {
        // Get percentage of progress
        percent = $(value).data('percentage');
        // Get radius of the svg's circle.complete
        radius = $(this).find($('circle.complete')).attr('r');
        // Get circumference (2πr)
        circumference = 2 * Math.PI * radius;
        // Get stroke-dashoffset value based on the percentage of the circumference
        strokeDashOffset = circumference - ((percent * circumference) / 100);
        // Transition progress for 1.25 seconds
        $(this).find($('circle.complete')).animate({'stroke-dashoffset': strokeDashOffset}, 2250);
    }
  });
}).trigger('scroll');


var currentNumber = $('.test-finish-circle__text').text();
var mark;

mark = $correctanswers/9*100;

$({numberValue: currentNumber}).animate({numberValue: mark}, {
    duration: 2000,
    easing: 'linear',
    step: function() {
        $('.test-finish-circle__text').text(Math.ceil(this.numberValue));
    }
});

});

JS;

$this->registerJs($js,\yii\web\View::POS_READY);
