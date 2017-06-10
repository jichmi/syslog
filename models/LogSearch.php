<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ArLog;

/**
 * LogSearch represents the model behind the search form about `app\models\ArLog`.
 */
class LogSearch extends ArLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user'], 'integer'],
            [['datetime', 'action', 'para'], 'safe'],
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
        $query = ArLog::find();

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
            'user' => $this->user,
            'datetime' => $this->datetime,
        ]);

        $query->andFilterWhere(['like', 'action', $this->action])
            ->andFilterWhere(['like', 'para', $this->para]);

        return $dataProvider;
    }
}
