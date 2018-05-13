<?php

use yii\helpers\Html;

?>

<a href="<?= $url ?? '/'?>" class="vacancy-list__item">
  <img class="vacancy-list__icon" src="<?= $src ?? 'no_file.png'?>" width="60" height="60" />
  <div class="vacancy-list__box">
    <p class="vacancy-list__date">02.04.2018</p>
    <p class="vacancy-list__text"><?= $title ?? 'link'?></p>
  </div>
</a>