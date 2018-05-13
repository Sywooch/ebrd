<?=$ratingJson?>
<div id="rating" data-id = "<?= $postId ?>" data-post="<?= $isBlogPost ?>" class="rating-container">
	<div class="rating-container__box">
		<div class="stars <?= $alreadyVoted?'fixed':''?>"></div>
		<p class="rate_progress" id="p1"></p>
	</div>
	<div class="rating rating-container__text"><?=$rating?></div>
</div>
