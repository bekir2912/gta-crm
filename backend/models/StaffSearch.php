<?php


namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Staff;




/**
 * StaffSearch represents the model behind the search form about `backend\models\Staff`.
 */
class StaffSearch extends Staff
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['FIO', 'position', 'birthday', 'phone', 'adress', 'status', 'created_at', 'images'], 'safe'],
            [['salary'], 'number'],
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
        $query = Staff::find();

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
            'birthday' => $this->birthday,
            'salary' => $this->salary,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'FIO', $this->FIO])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'adress', $this->adress])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'images', $this->images]);
         

        return $dataProvider;
    }
}
