<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ArLoginfo;

/**
 * LoginfoSearch represents the model behind the search form about `app\models\ArLoginfo`.
 */
class LoginfoSearch extends ArLoginfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['datetime', 'last', 'status', 'ip', 'ter', 'name'], 'safe'],
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
        $query = ArLoginfo::find();

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
        ]);

        $query->andFilterWhere(['like', 'datetime', $this->datetime])
            ->andFilterWhere(['like', 'last', $this->last])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'ter', $this->ter])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
