<?php

namespace backend\models;

use common\models\ShopReview;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SocialSearch represents the model behind the search form about `common\models\Social`.
 */
class ReviewSearch extends ShopReview
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'shop_id', 'rating', 'status', 'is_moderated'], 'safe'],
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
        $query = ShopReview::find();

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
            'is_moderated' => $this->is_moderated,
            'user_id' => $this->user_id,
            'shop_id' => $this->shop_id,
            'rating' => $this->rating,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
