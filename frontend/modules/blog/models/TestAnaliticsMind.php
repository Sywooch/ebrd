<?php

namespace frontend\modules\blog\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "test_analitics_mind".
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_answer
 * @property string $second_answer
 * @property string $third_answer
 * @property string $fourth_answer
 * @property string $fifth_answer
 * @property string $sixth_answer
 * @property string $seventh_answer
 * @property string $eighth_answer
 * @property string $ninth_answer
 *
 * @property User $user
 */
class TestAnaliticsMind extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_analitics_mind';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
			[['user_id'], 'integer'],
            [['first_answer', 'second_answer', 'third_answer', 'fourth_answer', 'fifth_answer', 'sixth_answer', 'seventh_answer', 'eighth_answer', 'ninth_answer'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'user_id' => Yii::t('blog', 'User ID'),
            'first_answer' => Yii::t('blog', 'First Answer'),
            'second_answer' => Yii::t('blog', 'Second Answer'),
            'third_answer' => Yii::t('blog', 'Third Answer'),
            'fourth_answer' => Yii::t('blog', 'Fourth Answer'),
            'fifth_answer' => Yii::t('blog', 'Fifth Answer'),
            'sixth_answer' => Yii::t('blog', 'Sixth Answer'),
            'seventh_answer' => Yii::t('blog', 'Seventh Answer'),
            'eighth_answer' => Yii::t('blog', 'Eighth Answer'),
            'ninth_answer' => Yii::t('blog', 'Ninth Answer'),
        ];
    }
	
	public function getCorrectAnswers()
	{
		$correctanswers = 0;
		if($this->isCorrectFirstAnswer()){
			$correctanswers += 1;
		}
		if($this->isCorrectSecondAnswer()){
			$correctanswers += 1;
		}
		if($this->isCorrectThirdAnswer()){
			$correctanswers += 1;
		}
		if($this->isCorrectFourthAnswer()){
			$correctanswers += 1;
		}
		if($this->isCorrectFifthAnswer()){
			$correctanswers += 1;
		}
		if($this->isCorrectSixthAnswer()){
			$correctanswers += 1;
		}
		if($this->isCorrectSeventhAnswer()){
			$correctanswers += 1;
		}
		if($this->isCorrectEighthAnswer()){
			$correctanswers += 1;
		}
		if($this->ninth_answer == 'E'){
			$correctanswers += 1;
		}
		return $correctanswers;
	}
	
	public function getMark()
	{
		$correctanswers = $this->getCorrectAnswers();
		$mark = 0;
		if($correctanswers >= 7){
			$mark = 5;
		}
		else if($correctanswers <= 6 && $correctanswers >= 4){
			$mark = 4;
		}
		else {
			$mark = 3;
		}
		return $mark;
	}
	
	public function isCorrectFirstAnswer()
	{
		if ($this->first_answer == 'A') {
			return true;
		}
		return false;
	}
	
	public function  isCorrectSecondAnswer()
	{
		if($this->second_answer == 'E'){
			return true;
		}
		return false;
	}
	
	public function isCorrectThirdAnswer()
	{
		if($this->third_answer == 'D'){
			return true;
		}
		return false;
	}
	
	public function isCorrectFourthAnswer()
	{
		if($this->fourth_answer == 'A'){
			return true;
		}
		return false;
	}
	
	public function isCorrectFifthAnswer()
	{
		if($this->fifth_answer == 'C'){
			return true;
		}
		return false;
	}
	
	public function isCorrectSixthAnswer()
	{
		if($this->sixth_answer == 'A'){
			return true;
		}
		return false;
	}
	
	public function isCorrectSeventhAnswer()
	{
		if($this->seventh_answer == 'B'){
			return true;
		}
		return false;
	}
	
	public function isCorrectEighthAnswer()
	{
		if($this->eighth_answer == 'E'){
			return true;
		}
		return false;
	}
	
	public function isCorrectNinthAnswer()
	{
		if($this->ninth_answer == 'E'){
			return true;
		}
		return false;
	}

	/**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
	
	public function saveTestResult($userid, $answers)
	{
		$this->user_id = $userid;
		$this->first_answer = $answers['radio1'];
		$this->second_answer = $answers['radio2'];
		$this->third_answer = $answers['radio3'];
		$this->fourth_answer = $answers['radio4'];
		$this->fifth_answer = $answers['radio5'];
		$this->sixth_answer = $answers['radio6'];
		$this->seventh_answer = $answers['radio7'];
		$this->eighth_answer = $answers['radio8'];
		$this->ninth_answer = $answers['radio9'];
		$this->save();
	}
}
