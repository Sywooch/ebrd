<?php
$this->title = Yii::t('blog', 'SITEMAP');

$this->registerMetaTag(['property' => 'og:description', 'content' => Yii::t('blog', 'SITEMAP')]);
$this->registerMetaTag(['name' => 'description', 'content' => Yii::t('blog', 'SITEMAP')]);
?>
<?= $html ?>
