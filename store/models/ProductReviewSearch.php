<?php

namespace store\models;

use common\models\Order;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OrderProduct;

/**
 * ProductReviewSearch represents the model behind the search form about `common\models\OrderProduct`.
 */
class ProductReviewSearch extends OrderProduct
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'product_id', 'price', 'amount', 'sum', 'comment_status', 'comment_rate', 'updated_at'], 'integer'],
            [['options', 'comment'], 'safe'],
            [['sale'], 'number'],
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
//        $query = Order::find()->joinWith(['orderProduct' => function($query){
//            $query->andWhere('`order_products`.`comment_status` => 1');
//        }])->where(['comment_status' => 1, 'shop_id' => Yii::$app->session->get('shop_id')]);
        $query = OrderProduct::find()->joinWith(['order' => function($query){
            $query->andWhere(['`orders`.`shop_id`' => Yii::$app->session->get('shop_id')]);
        }])->where('`order_products`.`comment_status` = 1');

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
            '`order_products`.`id`' => $this->id,
            '`order_products`.`order_id`' => $this->order_id,
            '`order_products`.`product_id`' => $this->product_id,
            '`order_products`.`price`' => $this->price,
            '`order_products`.`sale`' => $this->sale,
            '`order_products`.`amount`' => $this->amount,
            '`order_products`.`sum`' => $this->sum,
            '`order_products`.`comment_status`' => $this->comment_status,
            '`order_products`.`comment_rate`' => $this->comment_rate,
            '`order_products`.`created_at`' => $this->created_at,
            '`order_products`.`updated_at`' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'options', $this->options])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
