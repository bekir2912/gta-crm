<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Clients;

/**
 * ClientsSearch represents the model behind the search form about `backend\models\Clients`.
 */
class ClientsSearch extends Clients
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'staff_id'], 'integer'],
            [['is_seller', 'FIO', 'phone', 'pasport_serial', 'registration', 'brithsday', 'status', 'created_at'], 'safe'],
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
        $query = Clients::find();

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
            'staff_id' => $this->staff_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'is_seller', $this->is_seller])
            ->andFilterWhere(['like', 'FIO', $this->FIO])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'pasport_serial', $this->pasport_serial])
            ->andFilterWhere(['like', 'registration', $this->registration])
            ->andFilterWhere(['like', 'brithsday', $this->brithsday])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
