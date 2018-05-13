<?php
use yii\helpers\Html;

$this->title = $model->name;
$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'];
?>
<div class="report_view_container">
	<?php if(!empty($model->nav) && $model->nav != '{}'){ ?>
		<div class="report_tittle">
			<?= $model->name ?>
		</div>
		<div class="navigation_report">
			<?php
				$links = json_decode($model->nav, true);
				foreach ($links as $link){
					echo '<div class="report_link_inside">'.Html::a('<span><span>'.$link['name'].'</span></span>',$link['value'],['class' => 'link_frame_nav']).'</div>';
				}
			?>
		</div>
		<div class="frame_container_my">
	<?php } ?>
		<?php
			if(!empty($model->file)){
				echo '<iframe width="100%" height="100%" src="'.$url.'/reports/'.$model->file.'" frameborder="0" allowFullScreen="true"></iframe>';
			}else{
				echo '<iframe width="100%" height="100%" src="'.$model->report_content.'" frameborder="0" allowFullScreen="true"></iframe>';
			}
		?>
	<?php if(!empty($model->nav) && $model->nav != '{}'){ ?>
		</div>
	<?php } ?>
</div>