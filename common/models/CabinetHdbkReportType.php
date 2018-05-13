<?php

namespace common\models;

use Yii;
use frontend\modules\user\models\Reports;

/**
 * This is the model class for table "cabinet_hdbk_report_type".
 *
 * @property int $id
 * @property string $name
 */
class CabinetHdbkReportType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cabinet_hdbk_report_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'name' => Yii::t('blog', 'Name'),
        ];
    }
	
	public function getReport()
    {
        return $this->hasOne(Reports::className(), ['id' => 'type_id']);
    }
	
	public function getTypes()
    {
        $types = self::find()->all();
		$translatedTypes = [];
		foreach ($types as $type){
			$translatedTypes[$type->id] = Yii::t('blog', $type->name);
		}
		return $translatedTypes;
    }
	
	public function getEmailNameByType($type_id)
    {
        return self::find()->where(['id' => $type_id])->one();
    }
}
