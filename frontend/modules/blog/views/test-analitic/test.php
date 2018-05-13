<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\blog\models\BlogCategory */

$this->title = Yii::t('blog', 'TEST_ANALYTIC_PAGETITLE');
?>

<div class="test">
	<?php $form = ActiveForm::begin(); ?>
	<div class="test-hero">
		<div class="test-hero__container">
			<div class="test-hero__text flex__fdc">
				<p><?= Yii::t('blog', 'TEST_ANALYTIC_HERO')?></p>
				<hr>
			</div>

		</div>

	</div>

	<div id="test_analytic_skill" class="test__container">

		<div class="test__title">
			<span class="test__title-colored"><?= Yii::t('blog', 'TEST_ANALYTIC_TITLE_RED')?> </span><?= Yii::t('blog', 'TEST_ANALYTIC_TITLE') ?></div>
			<div id="test_item_1" class="test-item test-item__question-1 test-item-active">

				<div class="test-item__progress">
					<div class="test-item__progress-text">1</div>
				</div>

				<div class="test-item__content">
					<div class="test-item__title"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_1_TITLE') ?></div>

					<div class="test-item__question">
						<div class="test-item__question-container">
							<img src="/images/test_analytic/question1/test_quest_01.png" alt="question01" class="test-item__question-item"></img>
							<img src="/images/test_analytic/question1/test_quest_02.png" alt="question02" class="test-item__question-item"></img>
							<div class="test-item__question-item">?</div>
							<img src="/images/test_analytic/question1/test_quest_04.png" alt="question04" class="test-item__question-item"></img>
							<img src="/images/test_analytic/question1/test_quest_05.png" alt="question05" class="test-item__question-item"></img>
						</div>

						<div class="test-item__question-container flex flex__jcfe">
							<img src="/images/test_analytic/question1/test_quest_answ_01.png" alt="answ01" class="test-item__question-item"></img>
							<img src="/images/test_analytic/question1/test_quest_answ_02.png" alt="answ02" class="test-item__question-item"></img>
							<img src="/images/test_analytic/question1/test_quest_answ_03.png" alt="answ03" class="test-item__question-item"></img>
							<img src="/images/test_analytic/question1/test_quest_answ_04.png" alt="answ04" class="test-item__question-item"></img>
							<img src="/images/test_analytic/question1/test_quest_answ_05.png" alt="answ05" class="test-item__question-item"></img>
						</div>
					</div>

					<div class="test-item__answer">
						<div class="test-item__answer-text text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_1_QUESTION') ?></div>
						<div class="test-item__answer-container flex flex__jcfe">
							<label class="test-item__answer-item">
								<input type="radio" name="radio1" value="A">
								<span class="test-item__answer-item-text">A</span>
							</label>
							<label class="test-item__answer-item">
								<input type="radio" name="radio1" value="B">
								<span class="test-item__answer-item-text">B</span>
							</label>
							<label class="test-item__answer-item">
								<input type="radio" name="radio1" value="C">
								<span class="test-item__answer-item-text">C</span>
							</label>
							<label class="test-item__answer-item">
								<input type="radio" name="radio1" value="D">
								<span class="test-item__answer-item-text">D</span>
							</label>
							<label class="test-item__answer-item">
								<input type="radio" name="radio1" value="E">
								<span class="test-item__answer-item-text">E</span>
							</label>
						</div>
					</div>

					<div class="test-item-solution">
						<p class="test-item-solution__title"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_TITLE_SOLUTION') ?></p>
						<p class="test-item-solution__text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_1_SOLUTION') ?></p>
					</div>
				</div>
			</div>

			<div id="test_item_2" class="test-item test-item__question-2">
				<div class="test-item__progress"><div class="test-item__progress-text">2</div></div>

				<div class="test-item__content">
					<div class="test-item__title"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_2_TITLE') ?></div>
					<div class="test-item__question">

						<div class="test-item__question-container">
							<img src="/images/test_analytic/question2/test_quest_11.png" alt="question01" class="test-item__question-item"></img>
							<div class="test-item__question-item">?</div>
							<img src="/images/test_analytic/question2/test_quest_13.png" alt="question02" class="test-item__question-item"></img>
							<img src="/images/test_analytic/question2/test_quest_14.png" alt="question04" class="test-item__question-item"></img>
							<img src="/images/test_analytic/question2/test_quest_15.png" alt="question05" class="test-item__question-item"></img>
						</div>

						<div class="test-item__question-container flex flex__jcfe">
							<img src="/images/test_analytic/question2/test_quest_answ_11.png" alt="answ01" class="test-item__question-item"></img >
							<img src="/images/test_analytic/question2/test_quest_answ_12.png" alt="answ02" class="test-item__question-item"></img >
							<img src="/images/test_analytic/question2/test_quest_answ_13.png" alt="answ03" class="test-item__question-item"></img >
							<img src="/images/test_analytic/question2/test_quest_answ_14.png" alt="answ04" class="test-item__question-item"></img >
							<img src="/images/test_analytic/question2/test_quest_answ_15.png" alt="answ05" class="test-item__question-item"></img >
						</div>

					</div>

					<div class="test-item__answer">
						<div class="test-item__answer-text text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_2_QUESTION') ?></div>
						<div class="test-item__answer-container flex flex__jcfe">
							<label class="test-item__answer-item">
								<input type="radio" name="radio2" value="A">
								<span class="test-item__answer-item-text">A</span>
							</label>
							<label class="test-item__answer-item">
								<input type="radio" name="radio2" value="B">
								<span class="test-item__answer-item-text">B</span>
							</label>
							<label class="test-item__answer-item">
								<input type="radio" name="radio2" value="C">
								<span class="test-item__answer-item-text">C</span>
							</label>
							<label class="test-item__answer-item">
								<input type="radio" name="radio2" value="D">
								<span class="test-item__answer-item-text">D</span>
							</label>
							<label class="test-item__answer-item">
								<input type="radio" name="radio2" value="E">
								<span class="test-item__answer-item-text">E</span>
							</label>
						</div>
					</div>

					<div class="test-item-solution">
						<p class="test-item-solution__title"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_TITLE_SOLUTION') ?></p>
						<p class="test-item-solution__text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_2_SOLUTION') ?></p>
					</div>
				</div>
			</div>

			<div id="test_item_3" class="test-item test-item__question-3">
				<div class="test-item__progress"><div class="test-item__progress-text">3</div></div>

				<div class="test-item__content">
					<div class="test-item__title"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_3_TITLE') ?></div>

					<div class="test-item__question">
						<div class="test-item__question-container">
							<img src="/images/test_analytic/question3/test_quest_31.png" alt="question01" class="test-item__question-item"></img>
							<img src="/images/test_analytic/question3/test_quest_32.png" alt="question02" class="test-item__question-item"></img>
							<div class="test-item__question-item">?</div>
							<img src="/images/test_analytic/question3/test_quest_34.png" alt="question04" class="test-item__question-item"></img>
							<img src="/images/test_analytic/question3/test_quest_35.png" alt="question05" class="test-item__question-item"></img>
						</div>

						<div class="test-item__question-container flex flex__jcfe">
							<img src="/images/test_analytic/question3/test_quest_answ_31.png" alt="answ01" class="test-item__question-item"></img >
							<img src="/images/test_analytic/question3/test_quest_answ_32.png" alt="answ02" class="test-item__question-item"></img >
							<img src="/images/test_analytic/question3/test_quest_answ_33.png" alt="answ03" class="test-item__question-item"></img >
							<img src="/images/test_analytic/question3/test_quest_answ_34.png" alt="answ04" class="test-item__question-item"></img >
							<img src="/images/test_analytic/question3/test_quest_answ_35.png" alt="answ05" class="test-item__question-item"></img >
						</div>
					</div>

					<div class="test-item__answer">
						<div class="test-item__answer-text text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_3_QUESTION') ?></div>
						<div class="test-item__answer-container flex flex__jcfe">
							<label class="test-item__answer-item">
								<input type="radio" name="radio3" value="A">
								<span class="test-item__answer-item-text">A</span>
							</label>
							<label class="test-item__answer-item">
								<input type="radio" name="radio3" value="B">
								<span class="test-item__answer-item-text">B</span>
							</label>
							<label class="test-item__answer-item">
								<input type="radio" name="radio3" value="C">
								<span class="test-item__answer-item-text">C</span>
							</label>
							<label class="test-item__answer-item">
								<input type="radio" name="radio3" value="D">
								<span class="test-item__answer-item-text">D</span>
							</label>
							<label class="test-item__answer-item">
								<input type="radio" name="radio3" value="E">
								<span class="test-item__answer-item-text">E</span>
							</label>
						</div>
					</div>

					<div class="test-item-solution">
						<p class="test-item-solution__title"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_TITLE_SOLUTION') ?></p>
						<p class="test-item-solution__text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_3_SOLUTION') ?></p>
					</div>
				</div>
			</div>

			<div id="test_item_4" class="test-item test-item__question-4">
				<div class="test-item__progress"><div class="test-item__progress-text">4</div></div>

				<div class="test-item__content">
					<div class="test-item__title"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_4_TITLE') ?></div>

					<div class="test-item__question">
						<div class="flex flex__jcc">
							<div class="test-item__question-item-round text__c">5</div>
							<div class="test-item__question-item-round text__c">8</div>
							<div class="test-item__question-item-round text__c">12</div>
						</div>
						<div class="flex flex__jcc">
							<div class="test-item__question-item-round text__c">7</div>
							<div class="test-item__question-item-round text__c">12</div>
							<div class="test-item__question-item-round text__c">18</div>
						</div>
						<div class="flex flex__jcc">
							<div class="test-item__question-item-round text__c">3</div>
							<div class="test-item__question-item-round text__c">4</div>
							<div class="test-item__question-item-round text__c">?</div>
						</div>
					</div>

					<div class="test-item__answer flex flex__fdc">
						<div class="test-item__answer-container">
							<label class="test-item__answer-item">
								<input type="radio" name="radio4" value="A">
								<span class="test-item__answer-item-text">6</span>
							</label>
							<label class="test-item__answer-item">
								<input type="radio" name="radio4" value="B">
								<span class="test-item__answer-item-text">4</span>
							</label>
							<label class="test-item__answer-item">
								<input type="radio" name="radio4" value="C">
								<span class="test-item__answer-item-text">8</span>
							</label>
							<label class="test-item__answer-item">
								<input type="radio" name="radio4" value="D">
								<span class="test-item__answer-item-text">7</span>
							</label>
							<label class="test-item__answer-item">
								<input type="radio" name="radio4" value="E">
								<span class="test-item__answer-item-text">5</span>
							</label>
						</div>
					</div>

					<div class="test-item-solution">
						<p class="test-item-solution__title"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_TITLE_SOLUTION') ?></p>
						<p class="test-item-solution__text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_4_SOLUTION') ?></p>
					</div>
				</div>
			</div>

			<!-- <div class="test__title"><span class="test__title-colored">Second</span>part</div> -->

			<div id="test_item_5" class="test-item test-item__question-5">

				<div class="test-item__progress"><div class="test-item__progress-text">5</div></div>

				<div class="test-item__content flex flex__fdc">
					<div class="test-item__content">
						<div class="test-item__title"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_5_TITLE') ?></div>

						<div class="test-item__question test-item__question-5">
							<div class="test-item__question">

								<div class="test-item__question-container flex flex__fdc">
									<img src="/images/test_analytic/question5/test_quest_5.png" alt="quest5">
									<p class="test-item__image-description text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_5_IMAGE_DESCR') ?></p>
								</div>

								<div class="test-item__question-container flex flex__jfe">
									<div class="test-item__answer">

										<div class="test-item__answer-container flex flex__fdc ">
											<div class="flex flex__aic text">
												<label class="test-item__answer-item">
													<input type="radio" name="radio5" value="A">
													<span class="test-item__answer-item-text">A</span>
												</label>
												<p class="text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_5_ANSWER_01') ?></p>
											</div>
											<div class="flex flex__aic text">
												<label class="test-item__answer-item">
													<input type="radio" name="radio5" value="B">
													<span class="test-item__answer-item-text">B</span>
												</label>
												<p class="text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_5_ANSWER_02') ?></p>
											</div>
											<div class="flex flex__aic text">
												<label class="test-item__answer-item">
													<input type="radio" name="radio5" value="C">
													<span class="test-item__answer-item-text">C</span>
												</label>
												<p class="text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_5_ANSWER_03') ?></p>
											</div>
											<div class="flex flex__aic text">
												<label class="test-item__answer-item">
													<input type="radio" name="radio5" value="D">
													<span class="test-item__answer-item-text">D</span>
												</label>
												<p class="text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_5_ANSWER_04') ?></p>
											</div>
											<div class="flex flex__aic text">
												<label class="test-item__answer-item">
													<input type="radio" name="radio5" value="E">
													<span class="test-item__answer-item-text">E</span>
												</label>
												<p class="text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_5_ANSWER_05') ?></p>
											</div>

										</div>
									</div>

								</div>
							</div>

						</div>
					</div>

					<div class="test-item-solution">
						<p class="test-item-solution__title"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_TITLE_SOLUTION') ?></p>
						<p class="test-item-solution__text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_5_SOLUTION') ?></p>
					</div>
				</div>
			</div>

			<div id="test_item_6" class="test-item test-item__question-6">
				<div class="test-item__progress"><div class="test-item__progress-text">6</div></div>

				<div class="test-item__content">
					<div class="test-item__title"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_6_TITLE') ?></div>
					<div class="test-item__question test-item__question-6">
						<div class="test-item__question flex__fdc flex__jcc">

							<div class="test-item__question-container flex flex__fdc">
								<table class="test-table">
									<tr class="test-table__header">
										<td rowspan="2"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_6_TABLE_11') ?></td>
										<td rowspan="2"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_6_TABLE_12') ?></td>
										<td rowspan="2"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_6_TABLE_13') ?></td>
										<td colspan="2" class="test-table__header-p"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_6_TABLE_14') ?></td>
									</tr>
									<tr class="test-table__header">
										<td><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_6_TABLE_15') ?></td>
										<td><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_6_TABLE_16') ?></td>
									</tr>
									<tr>
										<td><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_6_TABLE_21') ?></td>
										<td>2572</td>
										<td>$ 7558</td>
										<td>$ 487</td>
										<td>$ 1574</td>
									</tr>
									<tr>
										<td><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_6_TABLE_31') ?></td>
										<td>1235</td>
										<td>$ 1587</td>
										<td>$ 831</td>
										<td>$ 928</td>
									</tr>
									<tr>
										<td><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_6_TABLE_41') ?></td>
										<td>957</td>
										<td>$ 3456</td>
										<td>$ 723</td>
										<td>$ 1375</td>
									</tr>
									<tr>
										<td><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_6_TABLE_51') ?></td>
										<td>1542</td>
										<td>$ 6875</td>
										<td>$ 427</td>
										<td>$ 3208</td>
									</tr>
									<tr>
										<td><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_6_TABLE_61') ?></td>
										<td>1012</td>
										<td>$ 3500</td>
										<td>$ 700</td>
										<td>$ 1789</td>
									</tr>
								</table>
							</div>

							<div class="test-item__answer flex flex__fdc">
								<div class="test-item__answer-text text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_6_QUESTION') ?></div>
								<div class="test-item__answer-container">

									<div class="flex flex__fdc flex__aic">
										<label class="test-item__answer-item">
											<input type="radio" name="radio6" value="A">
											<span class="test-item__answer-item-text">A</span>
										</label>
										<div class="test-item__answer-item-label"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_6_ANSWER_01') ?></div>
									</div>

									<div class="flex flex__fdc flex__aic">
										<label class="test-item__answer-item">
											<input type="radio" name="radio6" value="B">
											<span class="test-item__answer-item-text">B</span>
										</label>
										<div class="test-item__answer-item-label"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_6_ANSWER_02') ?></div>
									</div>

									<div class="flex flex__fdc flex__aic">
										<label class="test-item__answer-item">
											<input type="radio" name="radio6" value="C">
											<span class="test-item__answer-item-text">C</span>
										</label>
										<div class="test-item__answer-item-label"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_6_ANSWER_03') ?></div>
									</div>

									<div class="flex flex__fdc flex__aic">
										<label class="test-item__answer-item">
											<input type="radio" name="radio6" value="D">
											<span class="test-item__answer-item-text">D</span>
										</label>
										<div class="test-item__answer-item-label"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_6_ANSWER_04') ?></div>
									</div>

									<div class="flex flex__fdc flex__aic">
										<label class="test-item__answer-item">
											<input type="radio" name="radio6" value="E">
											<span class="test-item__answer-item-text">E</span>
										</label>
										<div class="test-item__answer-item-label"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_6_ANSWER_05') ?></div>
									</div>

								</div>
							</div>

						</div>
					</div>
					<div class="test-item-solution">
						<p class="test-item-solution__title"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_TITLE_SOLUTION') ?></p>
						<p class="test-item-solution__text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_6_SOLUTION') ?></p>
					</div>
				</div>

			</div>


			<div id="test_item_7" class="test-item test-item__question-7">
				<!-- test-item-active -->
				<div class="test-item__progress">
					<div class="test-item__progress-text">7</div>
				</div>

				<div class="test-item__content flex flex__fdc">
					<div class="test-item__title"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_7_TITLE') ?></div>
					<div class="test-item__question test-item__question-7">
						<div class="test-item__question flex__fdc flex__jcc">

							<div class="test-item__question-container flex flex__fdc">
								<table class="test-table">
									<tr class="test-table__header">
										<td></td>
										<td><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_7_TABLE_12') ?></td>
										<td><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_7_TABLE_13') ?></td>
										<td><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_7_TABLE_14') ?></td>
										<td><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_7_TABLE_15') ?></td>
										<td><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_7_TABLE_16') ?></td>
										<td><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_7_TABLE_17') ?></td>
										<td><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_7_TABLE_18') ?></td>
									</tr>
									<tr>
										<td>USD($)</td>
										<td>2.28</td>
										<td>1.44</td>
										<td>0.83</td>
										<td>0.56</td>
										<td>118.5</td>
										<td>1.29</td>
										<td>-</td>
									</tr>
									<tr>
										<td>Euro(€)</td>
										<td>2.74</td>
										<td>1.37</td>
										<td>-</td>
										<td>0.6</td>
										<td>142.4</td>
										<td>1.55</td>
										<td>1.20</td>
									</tr>
									<tr>
										<td>Yen(¥)</td>
										<td>0.019</td>
										<td>0.009</td>
										<td>0.007</td>
										<td>0.005</td>
										<td>-</td>
										<td>0.011</td>
										<td>0.008</td>
									</tr>
								</table>
							</div>

							<div class="test-item__answer flex flex__fdc">
								<div class="test-item__answer-text text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_7_QUESTION') ?></div>
								<div class="test-item__answer-container">

									<div class="flex flex__fdc flex__aic">
										<label class="test-item__answer-item">
											<input type="radio" name="radio7" value="A">
											<span class="test-item__answer-item-text">A</span>
										</label>
										<div class="test-item__answer-item-label"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_7_ANSWER_01') ?></div>
									</div>

									<div class="flex flex__fdc flex__aic">
										<label class="test-item__answer-item">
											<input type="radio" name="radio7" value="B">
											<span class="test-item__answer-item-text">B</span>
										</label>
										<div class="test-item__answer-item-label"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_7_ANSWER_02') ?></div>
									</div>

									<div class="flex flex__fdc flex__aic">
										<label class="test-item__answer-item">
											<input type="radio" name="radio7" value="C">
											<span class="test-item__answer-item-text">C</span>
										</label>
										<div class="test-item__answer-item-label"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_7_ANSWER_03') ?></div>
									</div>

									<div class="flex flex__fdc flex__aic">
										<label class="test-item__answer-item">
											<input type="radio" name="radio7" value="D">
											<span class="test-item__answer-item-text">D</span>
										</label>
										<div class="test-item__answer-item-label"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_7_ANSWER_04') ?></div>
									</div>

									<div class="flex flex__fdc flex__aic">
										<label class="test-item__answer-item">
											<input type="radio" name="radio7" value="E">
											<span class="test-item__answer-item-text">E</span>
										</label>
										<div class="test-item__answer-item-label"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_7_ANSWER_05') ?></div>
									</div>


								</div>
							</div>

						</div>
					</div>
					<div class="test-item-solution">
						<p class="test-item-solution__title"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_TITLE_SOLUTION') ?></p>
						<p class="test-item-solution__text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_7_SOLUTION') ?></p>
					</div>
				</div>
			</div>

			<div id="test_item_8" class="test-item test-item__question-8">
				<div class="test-item__progress">
					<div class="test-item__progress-text">8</div>
				</div>
				<div class="test-item__content">
					<div class="flex flex__fdc">
						<div class="test-item__title"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_8_TITLE') ?></div>
						<div class="test-item__question flex__fdr flex__jcc">

							<div class="test-item__image-container flex flex__fdc flex__jcsb flex__aic">
								<img class="test-item__stupid-image" src="/images/test_analytic/question8/test_quest_81.png" alt="quest8">
								<p class="test-item__image-description text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_8_IMAGE_DESCR_1') ?></p>
							</div>

							<div class="test-item__image-container flex flex__fdc flex__jcsb flex__aic">
								<img src="/images/test_analytic/question8/test_quest_82.png" alt="quest8">
								<p class="test-item__image-description text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_8_IMAGE_DESCR_2') ?></p>
							</div>

							<div class="test-item__image-container flex flex__fdc flex__jcsb flex__aic">
								<img src="/images/test_analytic/question8/test_quest_83.png" alt="quest8">
								<p class="test-item__image-description text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_8_IMAGE_DESCR_3') ?></p>
							</div>
						</div>

						<div class="test-item__answer flex flex__fdc">
							<div class="test-item__answer-text text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_8_QUESTION') ?></div>

							<div class="test-item__answer-container">

								<div class="flex flex__fdc flex__aic">
									<label class="test-item__answer-item">
										<input type="radio" name="radio8" value="A">
										<span class="test-item__answer-item-text">A</span>
									</label>
									<div class="test-item__answer-item-label"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_8_ANSWER_01') ?></div>
								</div>

								<div class="flex flex__fdc flex__aic">
									<label class="test-item__answer-item">
										<input type="radio" name="radio8" value="B">
										<span class="test-item__answer-item-text">B</span>
									</label>
									<div class="test-item__answer-item-label"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_8_ANSWER_02') ?></div>
								</div>

								<div class="flex flex__fdc flex__aic">
									<label class="test-item__answer-item">
										<input type="radio" name="radio8" value="C">
										<span class="test-item__answer-item-text">C</span>
									</label>
									<div class="test-item__answer-item-label"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_8_ANSWER_03') ?></div>
								</div>

								<div class="flex flex__fdc flex__aic">
									<label class="test-item__answer-item">
										<input type="radio" name="radio8" value="D">
										<span class="test-item__answer-item-text">D</span>
									</label>
									<div class="test-item__answer-item-label"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_8_ANSWER_04') ?></div>
								</div>

								<div class="flex flex__fdc flex__aic">
									<label class="test-item__answer-item">
										<input type="radio" name="radio8" value="E">
										<span class="test-item__answer-item-text">E</span>
									</label>
									<div class="test-item__answer-item-label"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_8_ANSWER_05') ?></div>
								</div>

							</div>
						</div>

					</div>

					<div class="test-item-solution">
						<p class="test-item-solution__title"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_TITLE_SOLUTION') ?></p>
						<p class="test-item-solution__text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_8_SOLUTION') ?></p>
					</div>
				</div>
			</div>

			<div id="test_item_9" class="test-item test-item__question-9">
				<div class="test-item__progress">
					<div class="test-item__progress-text">9</div>
				</div>
				<div class="test-item__content">
					<div class="flex flex__fdc">
						<div class="test-item__title"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_9_TITLE') ?></div>

						<div class="test-item__question flex__fdr flex__jcc">
							<div class="test-item__question-container flex flex__fdc">
								<img src="/images/test_analytic/question9/test_quest_9.png" alt="quest9">
								<p class="test-item__image-description text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_9_IMAGE_DESCR') ?></p>
							</div>
						</div>

						<div class="test-item__answer flex flex__fdc">
							<div class="test-item__answer-text text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_9_QUESTION') ?></div>
							<div class="test-item__answer-container">

								<div class="flex flex__fdc flex__aic">
									<label class="test-item__answer-item">
										<input type="radio" name="radio9" value="A">
										<span class="test-item__answer-item-text">A</span>
									</label>
									<div class="test-item__answer-item-label"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_9_ANSWER_01') ?></div>
								</div>

								<div class="flex flex__fdc flex__aic">
									<label class="test-item__answer-item">
										<input type="radio" name="radio9" value="B">
										<span class="test-item__answer-item-text">B</span>
									</label>
									<div class="test-item__answer-item-label"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_9_ANSWER_02') ?></div>
								</div>

								<div class="flex flex__fdc flex__aic">
									<label class="test-item__answer-item">
										<input type="radio" name="radio9" value="C">
										<span class="test-item__answer-item-text">C</span>
									</label>
									<div class="test-item__answer-item-label"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_9_ANSWER_03') ?></div>
								</div>

								<div class="flex flex__fdc flex__aic">
									<label class="test-item__answer-item">
										<input type="radio" name="radio9" value="D">
										<span class="test-item__answer-item-text">D</span>
									</label>
									<div class="test-item__answer-item-label"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_9_ANSWER_04') ?></div>
								</div>

								<div class="flex flex__fdc flex__aic">
									<label class="test-item__answer-item">
										<input type="radio" name="radio9" value="E">
										<span class="test-item__answer-item-text">E</span>
									</label>
									<div class="test-item__answer-item-label"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_9_ANSWER_05') ?></div>
								</div>

							</div>
						</div>

					</div>

					<div class="test-item-solution">
						<p class="test-item-solution__title"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_TITLE_SOLUTION') ?></p>
						<p class="test-item-solution__text"><?= Yii::t('blog', 'TEST_ANALYTIC_ITEM_9_SOLUTION') ?></p>
					</div>
				</div>
			</div>

		</div>
		<div class="test__end">
			<button id="test_analytic_skill_submit" class="test__button" disabled><?= Yii::t('blog', 'TEST_ANALYTIC_SUBMIT') ?></button>
		</div>


<!-- 		<div class="test-finish">
			<div class="test-finish-circle">

				<div class="test-finish-circle__filler"></div>
				<div class="test-finish-circle__result">
					<p>n</p>
				</div>

			</div>

			<div class="test-finish__block">
				<div class="test-finish__title flex flex__aic flex__nw">Mark:
					<div class="test-finish__mark">5</div>
				</div>
				<div class="test-finish__info flex flex__aic flex__jcsb">mrk:
					<div class="text text__c">5</div>
				</div>
				<div class="test-finish__info flex flex__aic flex__jcsb">mrk:
					<div class="text text__c">5</div>
				</div>
				<div class="test-finish__info flex flex__aic">percent
					<div class="text text__c">5</div>
				</div>
			</div>

			<div class="test-finish__success text">gg</div>

			<button id="test_show_correct" class="test__button test-finish__button">Show correct answers</button>
		</div> -->


	</div>
	<?php ActiveForm::end(); ?>
</div>

<?php
$js = <<<JS
$(document).ready(function() {
	var ti = $('.test-item'); // test item
	var answersCount;

	$('#test_show_correct').click(function () {
		$('.test-item-solution').slideDown();
	});

	$('.test-item__answer-item-text').click(function () {

		$(ti).removeClass('test-item-active');
		ti = $(this).closest(".test-item")
		$(ti).addClass('test-item-answered');
		ti = $(this).closest(".test-item").next('.test-item');
		$(ti).addClass('test-item-active');
		// console.log(ti);
		answersCount = $('.test').find('div.test-item-answered').length;
		console.log(answersCount);

		if (answersCount >= 9) {
			$('#test_analytic_skill_submit').prop('disabled', false).addClass('test__button-active');
		};

		$("html, body").animate({ scrollTop: $(ti).offset().top}, 300);

	});



	$('#test_analytic_skill_submit').click(function () {
		// кнопка сабмита
	});

	// console.log($('input[name="radio9"]:checked').val());

});

JS;

$this->registerJs($js);
