<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MemberLevel;

/**
 * MemberLevelSearch represents the model behind the search form about `app\models\MemberLevel`.
 */
class MemberLevelSearch extends MemberLevel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'bottom_num', 'top_num', 'rate'], 'integer'],
            [['level_name'], 'safe'],
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
        $query = MemberLevel::find();

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
            'bottom_num' => $this->bottom_num,
            'top_num' => $this->top_num,
            'rate' => $this->rate,
        ]);

        $query->andFilterWhere(['like', 'level_name', $this->level_name]);

        return $dataProvider;
    }
}
