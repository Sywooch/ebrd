<?php

namespace frontend\modules\plugins\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\plugins\models\PluginsAutolinkerGlobalSettings;

/**
 * PluginsAutolinkerGlobalSettingsSearch represents the model behind the search form about `frontend\modules\plugins\models\PluginsAutolinkerGlobalSettings`.
 */
class PluginsAutolinkerGlobalSettingsSearch extends PluginsAutolinkerGlobalSettings
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'lang_id'], 'integer'],
            [['setting_name', 'setting_description', 'settings_value', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PluginsAutolinkerGlobalSettings::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'lang_id' => $this->lang_id,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'setting_name', $this->setting_name])
            ->andFilterWhere(['like', 'setting_description', $this->setting_description])
            ->andFilterWhere(['like', 'settings_value', $this->settings_value]);

        return $dataProvider;
    }
}
