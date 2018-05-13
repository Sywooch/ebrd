<?php

namespace frontend\modules\plugins\shortcodes\content\initialize;

use frontend\modules\plugins\shortcodes\ShortcodeWidget;
use drmabuse\slick\SlickWidget;

/**
 * Class Initialize
 * @package frontend\modules\plugins\shortcodes
 * @author sanja
 */
class InitializeWidget extends ShortcodeWidget {

	public $slider_class;

	public $slide_to_show;

	public $dots;

	public $append_arrows;

	public $append_dots;

	public $desktop;

	public $tablet;

	public $tabletsm;

	public $mobile;

	public $as_nav;

	public $arrows;

	public $fading;

	public function init() {
		parent::init();
		$this->slide_to_show = intval($this->slide_to_show);
		$this->desktop = intval($this->desktop);
		$this->tablet = intval($this->tablet);
		$this->tabletsm = intval($this->tabletsm);
		$this->mobile = intval($this->mobile);
		$this->fading = boolval($this->fading);
	}

    public function run() {
		$slickConfig = [
			'container' => '.'.$this->slider_class,
			'settings'  => [
				'slick' => [
					'arrows' => $this->arrows,
					'autoplay' => true,
					'autoplaySpeed' => 6000,
					'speed' => 500,
					'edgeFriction' => 0,
					'prevArrow' => '<div class="prew_arrow"><svg><use xlink:href="#prew_arrow"></use></svg></div>',
					'nextArrow' => '<div class="next_arrow"><svg><use xlink:href="#next_arrow"></use></svg></div>',
					'infinite'      =>  true,
					'slidesToShow'  =>  $this->slide_to_show,
					'dots' => $this->dots,
					'fade' => $this->fading,
					'responsive' => [
						[
							'breakpoint'=> 1200,
							'settings'=> [
							  'slidesToShow'=> $this->desktop,
							  'slidesToScroll'=> 1,
							]
						],
						[
							'breakpoint'=> 900,
							'settings'=> [
							  'slidesToShow'=> $this->tablet,
							  'slidesToScroll'=> 1,
							]
						],
						[
							'breakpoint'=> 768,
							'settings'=> [
							  'slidesToShow'=> $this->tabletsm,
							  'slidesToScroll'=> 1,
							]
						],
						[
							'breakpoint'=> 480,
							'settings'=> [
							  'slidesToShow'=> $this->mobile,
							  'slidesToScroll'=> 1,
							]
						],
					],
				],
			]
		];

		if(!empty($this->append_arrows)){
			$slickConfig['settings']['slick']['appendArrows'] = '.'.$this->append_arrows;
		}

		if(!empty($this->append_dots)){
			$slickConfig['settings']['slick']['appendDots'] = '.'.$this->append_dots;
		}

		if(!empty($this->as_nav)){
			$slickConfig['settings']['slick']['asNavFor'] = '.'.$this->as_nav;
		}

		return SlickWidget::widget($slickConfig);
	}


}
