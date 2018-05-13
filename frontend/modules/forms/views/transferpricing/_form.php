<?php

use yii\widgets\ActiveForm;
use drmabuse\slick\SlickWidget;
?>

<div class="transfer-pricing">

	<?php $form = ActiveForm::begin(); ?>
	<div class="transfer-pricing__container js-slider-transferprice">

		<div class="transfer_pricing_slide transfer_first">
			<div class="slide_title_tp">Перевірка операцій з контрагентом-нерезидентом з т.з. трансфертного ціноутворення.</div>
			<div class="slide_warn_tp"><span>Увага!</span> Якщо ви хочете перевірити операції з декількома контрагентами-нерезидентами, потрібно перевіряти операції з різними контрагентами по черзі.</div>
			<div class="slide_warn_tp"><span>Увага!</span> Якщо ви мали більше однієї операції з одним контрагентом-нерезидентом, всі такі операції перевіряються разом.</div>
			<div class="slide_quest_tp">Оберіть звітний рік (протягом якого було здійснено операції з цим контрагентом):</div>
			<?= $form->field($model, 'year')->dropDownList($years, ['prompt' => 'Оберіть рік', 'class' => 'year_class'])->label(false) ?>
			<div class="notice">(*) Планова сума операцій</div>
		</div>

		<div class="transfer_pricing_slide transfer_second">
			<div class="slide_title_tp">Перевірка операцій з контрагентом-нерезидентом з т.з. трансфертного ціноутворення.</div>
			<div class="slide_warn_tp"><span>Увага!</span> Відповіді потрібно давати по одному контрагенту-нерезиденту та усім операціям з цим контрагентом.</div>
			<div class="slide_quest_tp">Позначте відповіді, які справедливі для операцій з окремим контрагентом-нерезидентом:</div>
			<div id="slide_to_third" class="slide_to_third">to 3</div><?= $form->field($model, 'res1', ['template' => '{input}{label}{error}'])->checkbox(['label' => null, 'id' => 'res_1'])->label('Цей контрагент є пов’язаною особою') ?>
			<?= $form->field($model, 'res2', ['template' => '{input}{label}{error}'])->checkbox(['label' => null, 'id' => 'res_2'])->label('Операції здійснювались за договором комісії (нерезидент є комісіонером)**') ?>
			<?= $form->field($model, 'res3', ['template' => '{input}{label}{error}'])->checkbox(['label' => null, 'id' => 'res_3'])->label('Контрагент з переліку країн з низькою ставкою податку на прибуток') ?>
			<?= $form->field($model, 'res4', ['template' => '{input}{label}{error}'])->checkbox(['label' => null, 'id' => 'res_4'])->label('Цей контрагент має організаційно-правову форму, яка звільняє його від податку на прибуток') ?>
			<?= $form->field($model, 'res5', ['template' => '{input}{label}{error}'])->checkbox(['label' => null, 'id' => 'res_5'])->label('Українська компанія є постійним представництвом нерезидента, з яким здійснювались господарські операції – показувати опцію тільки для 2018 р.') ?>
			<?= $form->field($model, 'res6', ['template' => '{input}{label}{error}'])->checkbox(['label' => null, 'id' => 'res_6'])->label('Контрагент є неприбутковою організацією** або бюджетною установою та надав товарів / послуг <span class="first_slide_select"></span> протягом року') ?>
			<?= $form->field($model, 'res7', ['template' => '{input}{label}{error}'])->checkbox(['label' => null, 'id' => 'res_7'])->label('Жодна з відповідей не описує операції з контрагентом') ?>
		</div>

		<div class="transfer_pricing_slide transfer_third">
			<div class="slide_title_tp">Перевірка операцій з контрагентом-нерезидентом з т.з. трансфертного ціноутворення.</div>
			<div class="slide_warn_tp"><span>Увага!</span> Відповіді потрібно давати по одному контрагенту-нерезиденту (перевіряються усі операції з цим контрагентом).</div>
			<?= $form->field($model, 'kek1',  ['template' => '{input}{label}{error}'])->checkbox(['label' => null, 'id' => 'kek_1'])->label('Платник податків безпосередньо та/або опосередковано (через пов’язаних осіб) володіє корпоративними правами Контрагента у розмірі 20 і більше відсотків') ?>
			<?= $form->field($model, 'kek2',  ['template' => '{input}{label}{error}'])->checkbox(['label' => null, 'id' => 'kek_2'])->label('Контрагент безпосередньо та/або опосередковано (через пов’язаних осіб) володіє корпоративними правами Платника податків у розмірі 20 і більше відсотків') ?>
			<?= $form->field($model, 'kek3',  ['template' => '{input}{label}{error}'])->checkbox(['label' => null, 'id' => 'kek_3'])->label('Є юридична або фізична особа, яка безпосередньо та/або опосередковано володіє корпоративними правами Платника податків та Контрагента у розмірі 20 і більше відсотків (у кожного)') ?>
			<?= $form->field($model, 'kek4',  ['template' => '{input}{label}{error}'])->checkbox(['label' => null, 'id' => 'kek_4'])->label('Є юридична або фізична особа, яка безпосередньо приймає рішення щодо призначення (обрання) одноособових виконавчих органів Платника податків та Контрагента (обох)') ?>
			<?= $form->field($model, 'kek5',  ['template' => '{input}{label}{error}'])->checkbox(['label' => null, 'id' => 'kek_5'])->label('Є юридична або фізична особа, яка приймає рішення щодо призначення (обрання) 50 і більше відсотків складу колегіального виконавчого органу (наприклад, ради директорів) або наглядової ради Платника податків та Контрагента (обох)') ?>
			<?= $form->field($model, 'kek6',  ['template' => '{input}{label}{error}'])->checkbox(['label' => null, 'id' => 'kek_6'])->label('Є фізичні особи, які складають принаймні 50 відсотків складу колегіального виконавчого органу (наприклад, ради директорів) та/або наглядової ради Платника податків та Контрагента (обох);') ?>
			<?= $form->field($model, 'kek7',  ['template' => '{input}{label}{error}'])->checkbox(['label' => null, 'id' => 'kek_7'])->label('Є особа (власник або уповноважений ним орган), який призначив одноособові виконавчі органи Платника податків та Контрагента (обох)') ?>
			<?= $form->field($model, 'kek8',  ['template' => '{input}{label}{error}'])->checkbox(['label' => null, 'id' => 'kek_8'])->label('Платник податків має повноваження на призначення (обрання) одноособового виконавчого органу Контрагента або на призначення (обрання) 50 і більше відсотків складу колегіального виконавчого органу або наглядової ради Контрагента') ?>
			<?= $form->field($model, 'kek9',  ['template' => '{input}{label}{error}'])->checkbox(['label' => null, 'id' => 'kek_9'])->label('Контрагент має повноваження на призначення (обрання) одноособового виконавчого органу Платника податків або на призначення (обрання) 50 і більше відсотків складу колегіального виконавчого органу або наглядової ради Платника податків') ?>
			<?= $form->field($model, 'kek10', ['template' => '{input}{label}{error}'])->checkbox(['label' => null, 'id' => 'kek_10'])->label('Тільки для 2018 р.: кінцевим бенефіціарним власником (контролером) Платника податків та Контрагента є одна і та сама фізична особа') ?>
			<?= $form->field($model, 'kek11', ['template' => '{input}{label}{error}'])->checkbox(['label' => null, 'id' => 'kek_11'])->label('Тільки для 2018 р.: є фізична особа, яка здійснює повноваження одноособового виконавчого органу Платника податків та Контрагента') ?>
			<?= $form->field($model, 'kek12', ['template' => '{input}{label}{error}'])->checkbox(['label' => null, 'id' => 'kek_12'])->label('сума всіх кредитів (позик), поворотної фінансової допомоги Платника податків Контрагенту та / або гарантій Платника податків за зобов’язаннями Контрагента перевищує суму власного капіталу більше ніж у 3,5 раза (для фінансових установ та компаній, що провадять виключно лізингову діяльність, - більше ніж у 10 разів) як середнє арифметичне значення (на початок та кінець звітного періоду)') ?>
			<?= $form->field($model, 'kek13', ['template' => '{input}{label}{error}'])->checkbox(['label' => null, 'id' => 'kek_13'])->label('сума всіх кредитів (позик), поворотної фінансової допомоги Контрагента Платнику податків та / або гарантій Контрагента за зобов’язаннями Платника податків перевищує суму власного капіталу більше ніж у 3,5 раза (для фінансових установ та компаній, що провадять виключно лізингову діяльність, - більше ніж у 10 разів) як середнє арифметичне значення (на початок та кінець звітного періоду)') ?>
			<?= $form->field($model, 'kek14', ['template' => '{input}{label}{error}'])->checkbox(['label' => null, 'id' => 'kek_14'])->label('Жоден з наведених варіантів не описує стосунки з цим Контрагентом') ?>

		</div>

		<div class="transfer_pricing_slide">

		</div>
		<div class="transfer_pricing_slide">

		</div>
		<div class="transfer_pricing_slide">

		</div>
		<div class="transfer_pricing_slide">

		</div>
		<div class="transfer_pricing_slide">

		</div>
		<div class="transfer_pricing_slide transfer_nine">
			<div class="slide_title_tp">Сума операцій з контрагентом</div>
			<div class="slide_warn_tp"><span>Увага!</span> Відповіді потрібно давати по одному контрагенту-нерезиденту (перевіряються усі операції з цим контрагентом).</div>
			<div class="slide_quest_tp">Зазначте суму операцій з контрагентом за звітний <span class="selected_year"></span> рік (в мільйонах грн.):</div>
			<?= $form->field($model, 'money')->textInput(['type' => 'number', 'min' => 0, 'class' => 'money_class', 'value' => 0])->label(false) ?>
			<div class="transfer_nine_custom">
				<div class="slide_quest_tp">Зазначте, чи здійснювались з цим контрагентом операції у звітному році після 27.07.2017 р.:</div>
				<?php $model->money_rario_1 = '1'; ?>
				<?= $form->field($model, 'money_rario_1')->radioList(['1' => 'Так', '2' => 'Ні'])->label(false); ?>
			</div>
			<div class="slide_quest_tp">Зазначте, чи контрагент виступав постачальником товарів / послуг, принаймні в частині операцій з ним:</div>
			<?php $model->money_rario_2 = '1'; ?>
			<?= $form->field($model, 'money_rario_2')->radioList(['1' => 'Так', '2' => 'Ні'])->label(false); ?>
		</div>
		<div class="transfer_pricing_slide transfer_ten">
			<div class="variant variant_1">Операції з контрагентом за звітний <span class="variant_year"></span> рік визнаються контрольованими в частині операцій, які було здійснено з контрагентом починаючи з 28.07.2017 р. Тому відповідно до вимог Податкового Кодексу вам необхідно:
				Скласти та надати до ДФС «Звіт про контрольовані операції» до 1 жовтня <span class="variant_year_plus"></span> року відповідно до п. 39.4.2. ПКУ згідно з інструкціями, затвердженими Наказом Мінфіну від 18.01.2016 № 8 <a href="http://zakon2.rada.gov.ua/laws/show/z0187-16" target="_blank">«Про затвердження форми та Порядку складання Звіту про контрольовані операції»</a>
				Підготувати документацію з трансфертного ціноутворення відповідно до вимог п.39.4.6. ПКУ та бути готовим надати її на вимогу ДФС після 1 жовтня <span class="variant_year_plus"></span> року.</div>
				<div class="variant variant_2">Операції з контрагентом за звітний <span class="variant_year"></span> рік визнаються контрольованими в повній сумі <span class="variant_money"></span> млн. грн. Тому відповідно до вимог Податкового Кодексу вам необхідно:
					Скласти та надати до ДФС «Звіт про контрольовані операції» до 1 жовтня <span class="variant_year_plus"></span> року відповідно до п. 39.4.2. ПКУ згідно з інструкціями, затвердженими Наказом Мінфіну від 18.01.2016 № 8 <a href="http://zakon2.rada.gov.ua/laws/show/z0187-16" target="_blank">«Про затвердження форми та Порядку складання Звіту про контрольовані операції»</a>
					Підготувати документацію з трансфертного ціноутворення відповідно до вимог п.39.4.6. ПКУ та бути готовим надати її на вимогу ДФС після 1 жовтня <span class="variant_year_plus"></span> року.</div>
					<div class="variant variant_3">Операції з контрагентом за звітний <span class="variant_year"></span> рік не контрольованими. Але відповідно до вимог Податкового Кодексу вам необхідно:
						Або відповідно до п. 140.5.4. збільшити фінансовий результат податкового (звітного) періоду на 30% від вартості товарів / послуг, придбаних у контрагента;
						Або підготувати документацію з трансфертного ціноутворення (за умови, що ціна товарів / послуг в операціях з контрагентом відповідала ринковому рівню) відповідно до вимог п.39.4.6. ПКУ та бути готовим надати її на вимогу ДФС після 1 жовтня <span class="variant_year_plus"></span> року.
					Як правило, друга опція є більш вигідною для платника податків, якщо сума покупок у контрагента перевищує 1 млн. грн.</div>
					<div class="variant variant_4">Операції не визнаються контрольованими (за п. 39.2.1.1. ПКУ) та не вимагають збільшення фінансового результату року (за п.140.5.4. ПКУ).</div>
				</div>
				<div class="transfer_pricing_slide transfer_finish">
					<div class="slide_warn_tp"><span>Увага!</span> Наданий аналіз може не враховувати в достатній мірі дрібні деталі операцій. Для отримання повної діагностики наявності зіставних операцій ви можете звернутись до нас по додаткову консультацію.</div>
					<div class="slide_quest_tp">Отримати додаткову консультацію. Залиште телефон:</div>
					<?= $form->field($model, 'phone')->textInput(['class' => 'phone_class_tp'])->label(false) ?>
				</div>


			</div>

			<div class="transfer_pricing_progress_bar_container">
				<div class="transfer_pricing_prew slick-arrow slick-disabled">Назад</div>
				<div class="transfer_pricing_progress_bar">
					<div class="progress_jar"><span class="process">0</span></div>
				</div>
				<div class="transfer_pricing_next slick-arrow slick-disabled">Далі</div>
				<!-- <button class="slider_submit_tp" type="submit">Готово</button> -->
			</div>
			<?php ActiveForm::end(); ?>
		</div>

		<?=
		SlickWidget::widget([
			'container' => '.js-slider-transferprice',
			'settings' => [
				'slick' => [
					'arrows' => false,
					'autoplay' => false,
					'speed' => 800,
					'edgeFriction' => 0,
					'infinite' => false,
					'slidesToShow' => 1,
					'accessibility' => false,
					'dots' => false,
					'adaptiveHeight' => true,
					'fade' => true,
					'swipe' => false,
				],
			],
		]);
		?>

<?php
$js = <<<JS
	var slide_to = 0,
		slides_map = [],
		old_progress,
		new_progress = 0,
		last_results = {},
		second_validation = [],
		current_slide = 0;

	$('.js-slider-transferprice').on('afterChange', function(event, slick, currentSlide){
		current_slide = currentSlide;
	})

	$('.js-slider-transferprice').on('beforeChange', function(event, slick, currentSlide, nextSlide){
		if(nextSlide == 0){
			$('.transfer_pricing_prew').addClass('slick-disabled');
		}else{
			$('.transfer_pricing_prew').removeClass('slick-disabled');
		}
		//Progress Funsctions
		old_progress = $('.process').text();
		if(currentSlide > nextSlide){
			new_progress = new_progress - 25;
			$('.transfer_pricing_next').removeClass('slick-disabled');
		}else{
			new_progress = new_progress + 25;
			$('.transfer_pricing_next').addClass('slick-disabled');
		}
		if(new_progress == 0){
			setTimeout (function(event){
				$('.transfer_pricing_progress_bar').removeClass('transfer_pricing_progress_bar_visible')
			},600)
		}else{
			$('.transfer_pricing_progress_bar').addClass('transfer_pricing_progress_bar_visible')
		}
		$('.progress_jar').css({'width': new_progress+'%'});
		$('.process').text(new_progress);
		$('.process').each(function() {
			$(this).prop('Counter', old_progress).animate({
			  Counter: $(this).text()
			},{
				duration: 800,
				easing: 'swing',
				step: function(now) {
				$(this).text(Math.ceil(now));
			  }
			});
		});

		if(current_slide == 0 && second_validation.length != 0){
			$('.transfer_pricing_next').removeClass('slick-disabled');
			slide_to = 8;
		}

		if(current_slide == 1 && last_results['money'] != null){
			$('.transfer_pricing_next').removeClass('slick-disabled');
			slide_to = 9;
		}
		if(nextSlide == 9){
			$('.transfer_pricing_next').removeClass('slick-disabled');
			$('.transfer_pricing_next').removeClass('slick-disabled-real');
			$('.slider_submit_tp').removeClass('slider_submit_tp_visible');
			slide_to = 10;
		}
	});

	//First Slide Logic
	var first_slide_input;
	$('.js-slider-transferprice').on('input','.transfer_first .year_class',function(event){
		if($(this).val() != ''){
			if($(this).val() == 0){
				first_slide_input = 'на будь-яку суму';
				last_results['year'] = '2015';
			}else if($(this).val() == 1){
				first_slide_input = 'на суму понад 68 900 грн.';
				last_results['year'] = '2016';
			}else if($(this).val() == 2){
				first_slide_input = 'на суму понад 80 000 грн.';
				last_results['year'] = '2017';
			}else if($(this).val() == 3){
				first_slide_input = 'на суму понад 93 075 грн.';
				last_results['year'] = '2018';
			}
			$('.first_slide_select').text(first_slide_input);
			$('.selected_year').text(last_results['year']);
			$('.transfer_pricing_next').removeClass('slick-disabled');
			slide_to = 1;
		}else{
			$('.transfer_pricing_next').addClass('slick-disabled');
		}
	});

	//Second Slide Logic
	var res_second_obj = {'res_1': false, 'res_2': false, 'res_3': false, 'res_4': false, 'res_5': false, 'res_6': false, 'res_7': false};

	$('.js-slider-transferprice').on('change','.transfer_second input',function(event){



		curent_id = $(this).attr('id');
		curent_prop = $(this).prop('checked');
		res_second_obj[curent_id] = curent_prop;
		if(res_second_obj['res_3'] == true && res_second_obj['res_4'] == true){
			if($(this).attr('id') == 'res_3'){
				$('#res_4').prop('checked', false );
				res_second_obj['res_4'] = false;
			}else if($(this).attr('id') == 'res_4'){
				$('#res_3').prop('checked', false );
				res_second_obj['res_3'] = false;
			}
		}
		if(res_second_obj['res_7'] == true){
			$('#res_1,#res_2,#res_3,#res_4,#res_5,#res_6').attr('disabled','disabled');
			$('#res_1,#res_2,#res_3,#res_4,#res_5,#res_6').prop('checked', false );
			res_second_obj['res_1'] = false;
			res_second_obj['res_2'] = false;
			res_second_obj['res_3'] = false;
			res_second_obj['res_4'] = false;
			res_second_obj['res_5'] = false;
			res_second_obj['res_6'] = false;
		}else if(res_second_obj['res_7'] == false){
			$('#res_1,#res_2,#res_3,#res_4,#res_5,#res_6').removeAttr('disabled')
		}

		$.each(res_second_obj, function(key, value){
			if(value == true){
				console.log(res_second_obj)
				if($.inArray(key, second_validation) < 0){
					second_validation.push(key);
				}
			}else if(value == false){
				second_validation = $.grep(second_validation, function(spec) {
					return spec != key;
				});
			}
		})
		if(second_validation.length == 0){
			$('.transfer_pricing_next').addClass('slick-disabled');
		}else{
			$('.transfer_pricing_next').removeClass('slick-disabled');
			slide_to = 8;
			last_results['checkbox'] = second_validation;
		}
		if(res_second_obj['res_4'] == true && second_validation.length == 1 && last_results['year'] == 2017){
			$('.transfer_nine_custom').addClass('transfer_nine_custom_visible');
		}else{
			$('.transfer_nine_custom').removeClass('transfer_nine_custom_visible');
		}

		// $('#slide_to_third').click(function () {
		// 	slide_to = 3;
		// });
	});

	//Third Slide Logic
	var kek_third_obj = {'kek_1': false, 'kek_2': false, 'kek_3': false, 'kek_4': false, 'kek_5': false, 'kek_6': false, 'kek_7': false, 'kek_8': false, 'kek_9': false, 'kek_10': false, 'kek_11': false, 'kek_12': false, 'kek_13': false, 'kek_14': false};

	$('.js-slider-transferprice').on('change','.transfer_third input',function(event){

		curent_id = $(this).attr('id');
		curent_prop = $(this).prop('checked');
		kek_third_obj[curent_id] = curent_prop;
		if(kek_third_obj['kek_3'] == true && kek_third_obj['kek_4'] == true){
			if($(this).attr('id') == 'kek_3'){
				$('#kek_4').prop('checked', false );
				kek_third_obj['kek_4'] = false;
			}else if($(this).attr('id') == 'kek_4'){
				$('#kek_3').prop('checked', false );
				kek_third_obj['kek_3'] = false;
			}
		}
		if(kek_third_obj['kek_7'] == true){
			$('#kek_1,#kek_2,#kek_3,#kek_4,#kek_5,#kek_6').attr('disabled','disabled');
			$('#kek_1,#kek_2,#kek_3,#kek_4,#kek_5,#kek_6').prop('checked', false );
			kek_third_obj['kek_1'] = false;
			kek_third_obj['kek_2'] = false;
			kek_third_obj['kek_3'] = false;
			kek_third_obj['kek_4'] = false;
			kek_third_obj['kek_5'] = false;
			kek_third_obj['kek_6'] = false;
		}else if(kek_third_obj['kek_7'] == false){
			$('#kek_1,#kek_2,#kek_3,#kek_4,#kek_5,#kek_6').removeAttr('disabled')
		}

		$.each(kek_third_obj, function(key, value){
			if(value == true){
				console.log(kek_third_obj)
				if($.inArray(key, third_validation) < 0){
					third_validation.push(key);
				}
			}else if(value == false){
				third_validation = $.grep(third_validation, function(spec) {
					return spec != key;
				});
			}
		})
		if(third_validation.length == 0){
			$('.transfer_pricing_next').addClass('slick-disabled');
		}else{
			$('.transfer_pricing_next').removeClass('slick-disabled');
			slide_to = 8;
			last_results['checkbox'] = third_validation;
		}
		if(kek_third_obj['res_4'] == true && third_validation.length == 1 && last_results['year'] == 2017){
			$('.transfer_nine_custom').addClass('transfer_nine_custom_visible');
		}else{
			$('.transfer_nine_custom').removeClass('transfer_nine_custom_visible');
		}
	});

	//Nine Slide Logic
	$('.js-slider-transferprice').on('input','.transfer_nine .money_class',function(event){

		last_results['money'] = $('.money_class').val();
		last_results['important_radio'] = $("input[name='TransferPricing[money_rario_2]']:checked").val();
		if(last_results['money'] == null){
			$('.transfer_pricing_next').addClass('slick-disabled');
		}else{
			$('.transfer_pricing_next').removeClass('slick-disabled');
			slide_to = 9;

			$('.variant_year').text(last_results['year']);
			$('.variant_year_plus').text(parseInt(last_results['year']) + 1);
			$('.variant_money').text(last_results['money']);
			$('.variant').removeClass('visible_variant');

			if(((last_results['year'] == '2015') || (last_results['year'] == '2016')) && (last_results['money'] >= 5) && (($.inArray('res_1', last_results['checkbox']) >= 0) || ($.inArray('res_2', last_results['checkbox']) >= 0) || ($.inArray('res_3', last_results['checkbox']) >= 0) || ($.inArray('res_4', last_results['checkbox']) >= 0) || ($.inArray('res_5', last_results['checkbox']) >= 0))){
				$('.variant_2').addClass('visible_variant');
			}

			if(((last_results['year'] == '2017') || (last_results['year'] == '2018')) && (last_results['money'] >= 10) && (($.inArray('res_1', last_results['checkbox']) >= 0) || ($.inArray('res_2', last_results['checkbox']) >= 0) || ($.inArray('res_3', last_results['checkbox']) >= 0) || ($.inArray('res_4', last_results['checkbox']) >= 0) || ($.inArray('res_5', last_results['checkbox']) >= 0))){
				$('.variant_2').addClass('visible_variant');
			}

			if((((last_results['year'] == '2015') || (last_results['year'] == '2016')) && (last_results['money'] < 5) && (($.inArray('res_1', last_results['checkbox']) >= 0) || ($.inArray('res_2', last_results['checkbox']) >= 0) || ($.inArray('res_3', last_results['checkbox']) >= 0) || ($.inArray('res_4', last_results['checkbox']) >= 0) || ($.inArray('res_5', last_results['checkbox']) >= 0))) || (($.inArray('res_6', last_results['checkbox']) >= 0) && last_results['important_radio'] == 1 )){
				$('.variant_3').addClass('visible_variant');
			}

			if((((last_results['year'] == '2017') || (last_results['year'] == '2018')) && (last_results['money'] < 10) && (($.inArray('res_1', last_results['checkbox']) >= 0) || ($.inArray('res_2', last_results['checkbox']) >= 0) || ($.inArray('res_3', last_results['checkbox']) >= 0) || ($.inArray('res_4', last_results['checkbox']) >= 0) || ($.inArray('res_5', last_results['checkbox']) >= 0))) || (($.inArray('res_6', last_results['checkbox']) >= 0) && last_results['important_radio'] == 1 )){
				$('.variant_3').addClass('visible_variant');
			}

			if((last_results['year'] == '2017') && ((last_results['checkbox'].length == 1) && (last_results['checkbox'] == 'res_4')) && (last_results['money'] > 10)){
				$('.variant').removeClass('visible_variant');
				$('.variant_1').addClass('visible_variant');
			}

		}
	});
	//Ten Slide Logic
	$('.js-slider-transferprice').on('input','.transfer_finish .phone_class_tp',function(event){
		if($(this).val() != ''){
			$('.slider_submit_tp').addClass('slider_submit_tp_visible');
			$('.transfer_pricing_next').addClass('slick-disabled-real');
		}
	});
	//Arrows Logic
	$('.transfer_pricing_next').on('click',function(){
		if(!$(this).hasClass('slick-disabled')){
			slides_map.push(slide_to);
			slide_action = slide_to;
			slickTo(slide_action);
		}
	})
	$('.transfer_pricing_prew').on('click',function(){
		if(!$(this).hasClass('slick-disabled')){
			slide_action = slides_map[slides_map.length-2];
			slickTo(slide_action);
			slide_to = slides_map[slides_map.length-1];
			slides_map.splice(-1,1)
		}
	})
	//Slide Function
	function slickTo(slide_action){
		$('.js-slider-transferprice').slick('slickGoTo', slide_action);
	}

JS;
$this->registerJs($js);
?>
