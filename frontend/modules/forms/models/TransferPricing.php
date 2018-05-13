<?php

namespace frontend\modules\forms\models;

use Yii;

/**
 * This is the model class for table "transfer_pricing".
 *
 * @property int $id
 * @property string $year
 * @property string $created_at
 */
class TransferPricing extends \yii\db\ActiveRecord
{
	public $year;

	public $money;

	public $res1, $res2, $res3, $res4, $res5, $res6, $res7;
	public $kek1, $kek2, $kek3, $kek4, $kek5, $kek6, $kek7, $kek8, $kek9, $kek10, $kek11, $kek12, $kek13, $kek14;


	public $money_rario_1;

	public $money_rario_2;

	public $phone;


	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transfer_pricing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['created_at','res1','res2','res3','res4','res5','res6','res7','money','money_rario_1','money_rario_2','phone','result'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'created_at' => Yii::t('blog', 'Created At'),
        ];
    }

	public function saveAsJson($post)
	{
		$this->result = json_encode($post["TransferPricing"]);
		$this->save();
	}

}
