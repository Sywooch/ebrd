<?php

namespace frontend\modules\plugins\models;

use Yii;

/**
 * This is the model class for table "plugins_country_location_code".
 *
 * @property integer $id
 * @property string $cc_fips
 * @property string $cc_iso
 * @property string $tld
 * @property string $country_name
 */
class PluginsCountryLocationCode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plugins_country_location_code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cc_fips', 'cc_iso'], 'string', 'max' => 2],
            [['tld'], 'string', 'max' => 3],
            [['country_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('blog', 'ID'),
            'cc_fips' => Yii::t('blog', 'Cc Fips'),
            'cc_iso' => Yii::t('blog', 'Cc Iso'),
            'tld' => Yii::t('blog', 'Tld'),
            'country_name' => Yii::t('blog', 'Country Name'),
        ];
    }
	
	public function getCountrycode()
    {
        return $this->hasOne(PluginsCountryLocationCode::className(), ['id' => 'cc_iso']);
    } 
}
