<?php

namespace store\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;
use yii\db\Expression;

/**
 * OrderSearch represents the model behind the search form about `common\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'shop_id',  'user_id', 'sum', 'comment_status', 'comment_rate', 'pay_status', 'pay_amount', 'status', 'created_at', 'updated_at'], 'integer'],
            [['service'], 'number'],
            [['name',  'pay_method', 'delivery_id','phone', 'email', 'address', 'comment', 'transaction'], 'safe'],
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
        $query = Order::find()->where(['shop_id' => Yii::$app->session->get('shop_id')]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSize'],
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
            'shop_id' => $this->shop_id,
            'service' => $this->service,
            'user_id' => $this->user_id,
            'pay_method' => $this->pay_method,
            'sum' => $this->sum,
            'comment_status' => $this->comment_status,
            'comment_rate' => $this->comment_rate,
            'pay_status' => $this->pay_status,
            'pay_amount' => $this->pay_amount,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        if($this->delivery_id === 'null') {
            $query->andFilterWhere(['IS', 'delivery_id', (new Expression('Null'))]);
        }
        elseif($this->delivery_id) {
            $query->andFilterWhere(['delivery_id' => $this->delivery_id]);
        }


        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'transaction', $this->transaction]);

        return $dataProvider;
    }
}
