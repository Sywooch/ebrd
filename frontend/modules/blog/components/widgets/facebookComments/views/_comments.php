<?php
?>
<div id="fb-root"></div>
<script>
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); 
		js.id = id;
		js.src = "<?= $this->context->src ?>";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>
<?= \yii\helpers\Html::tag('div', null, [
    'class' => 'fb-comments',
    'data' => [
        'href' => \yii\helpers\Url::current([], true),
        'numposts' => $this->context->numPosts,
    ]
]); ?>
