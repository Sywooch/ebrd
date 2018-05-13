<?php
use yii\helpers\Html;
?>
<div class="treal_office">
<div class="blog-contacts-item map_change_coords" data-id="<?= $model->id ?>">

	<div class="office_name">
		<?php echo Yii::t('plugins', $model->office_name); ?>
	</div>
	<hr class="office_hr">
	<div class="office_infos">
		<div class="office_country">
			<div class="office_country_svg"><svg><use xlink:href="#map_pin"></use></svg></div>
			<div class="office_country_texting"><?= Yii::t('plugins', $model->office_country) .'<br>'. Yii::t('plugins', $model->office_address); ?></div>
		</div>
		<div class="office_phone">
			<div class="office_phone_svg"><svg><use xlink:href="#phone_pin"></use></svg></div>
			<div class="office_phone_texting">
				<?php
				$arrPhones = explode("<br />", $model->phone);

				foreach ($arrPhones as $phone) {

					$cutSpace = str_replace(' ', '', $phone);
					echo Html::a($phone, "tel:$cutSpace") . '<br />';
				}		
				?>
			</div>
		</div>
		<div class="office_email">
			<button type="button" class="formBtn open_popup order_modal_contacts" data-formid="18"><?= Yii::t('blog', 'SEND_MAIL') ?></button>
		</div>
	</div>
</div>
<!--<div class="blog-contacts-item map_change_coords" data-id="<?= $model->id ?>">
	<?php // echo '<div style="width:200px;height:200px;" id="'.$model->id.'"></div>'; ?>
</div>-->

<div class="blog-contacts-item map_change_coords" data-id="<?= $model->id ?>">
	<?php $src = "$model->content"?>
	<iframe src=<?=$src?> width='100%' height='250' frameborder='0' style='border:0' allowfullscreen></iframe>
</div>
</div>
