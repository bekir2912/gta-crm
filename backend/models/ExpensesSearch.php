<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Expenses;

/**
 * ExpensesSearch represents the model behind the search form about `common\models\Expenses`.
 */
class ExpensesSearch extends Expenses
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'exp_id', 'status'], 'integer'],
            [['name', 'discription', 'created_at', 'updated_at'], 'safe'],
            [['price'], 'number'],
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
        $query = Expenses::find();

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
            'exp_id' => $this->exp_id,
            'price' => $this->price,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);
    
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'discription', $this->discription]);

        return $dataProvider;
    }
}
