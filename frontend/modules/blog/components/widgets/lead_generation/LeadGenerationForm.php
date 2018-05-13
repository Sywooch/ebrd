<?php
namespace frontend\modules\blog\components\widgets\lead_generation;

use yii\base\Model;

/**
 * Password reset form
 */
class LeadGenerationForm extends Model
{
	public $complexity;
	
    public $range;
	
	public $sum;
	
	public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['complexity','range', 'email'],'required'],
			[['email'],'email'],
            ['complexity', 'compare', 'compareValue' => 4, 'operator' => '<=', 'type' => 'number'],
			['range', 'compare', 'compareValue' => 200, 'operator' => '<=', 'type' => 'number'],
        ];
    }
}
