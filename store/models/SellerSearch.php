<?php

namespace store\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Seller;

/**
 * SellerSearch represents the model behind the search form about `common\models\Seller`.
 */
class SellerSearch extends Seller
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'trim'],
            [['ucard'], 'integer'],
            ['name', 'required'],
            ['name', 'string', 'min' => 2, 'max' => 255],
            ['phone', 'string'],
//            ['phone', 'string', 'min' => 12, 'max' => 12],
//            ['phone', 'match', 'pattern' => '/^\\d{12}$/i'],

//            ['email', 'trim'],
//            ['email', 'required'],
//            ['email', 'email'],
//            ['email', 'string', 'max' => 255],
//            ['phone', 'unique', 'targetClass' => '\common\models\User', 'when' => function($model) {return $model->phone != Yii::$app->getUser()->identity->phone;}],

//            ['password', 'required'],
            [['password'], 'string', 'min' => 6],
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
        $query = Seller::find()->andWhere(['deleted_at' => 0]);

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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token]);

        return $dataProvider;
    }
}
