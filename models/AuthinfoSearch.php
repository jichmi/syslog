<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ArAuthinfo;

/**
 * AuthinfoSearch represents the model behind the search form about `app\models\ArAuthinfo`.
 */
class AuthinfoSearch extends ArAuthinfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['datetime', 'user', 'grantor', 'order'], 'safe'],
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
        $query = ArAuthinfo::find();

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
            'datetime' => $this->datetime,
        ]);

        $query->andFilterWhere(['like', 'user', $this->user])
            ->andFilterWhere(['like', 'grantor', $this->grantor])
            ->andFilterWhere(['like', 'order', $this->order]);

        return $dataProvider;
    }
}
