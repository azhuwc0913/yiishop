<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Goods;

/**
 * GoodsSearch represents the model behind the search form about `app\models\Goods`.
 */
class GoodsSearch extends Goods
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cat_id', 'is_promote', 'promote_start_time', 'promote_end_time', 'is_delete', 'is_on_sale', 'is_hot', 'is_new', 'is_best', 'type_id', 'addtime'], 'integer'],
            [['goods_name', 'logo', 'sm_logo', 'goods_desc'], 'safe'],
            [['shop_price', 'market_price', 'promote_price'], 'number'],
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
        $query = Goods::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
            'pageSize' => 3,
            ],
            'sort' => [
                'defaultOrder' => [
                    'addtime' => 'SORT_DESC'
                ]
            ],
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
            'cat_id' => $this->cat_id,
            'shop_price' => $this->shop_price,
            'market_price' => $this->market_price,
            'is_promote' => $this->is_promote,
            'promote_price' => $this->promote_price,
            'promote_start_time' => $this->promote_start_time,
            'promote_end_time' => $this->promote_end_time,
            'is_delete' => $this->is_delete,
            'is_on_sale' => $this->is_on_sale,
            'is_hot' => $this->is_hot,
            'is_new' => $this->is_new,
            'is_best' => $this->is_best,
            'type_id' => $this->type_id,
            'addtime' => $this->addtime,
        ]);

        $query->andFilterWhere(['like', 'goods_name', $this->goods_name])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'sm_logo', $this->sm_logo])
            ->andFilterWhere(['like', 'goods_desc', $this->goods_desc]);

        return $dataProvider;
    }
}
