<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Laudo;

/**
 * LaudoSearch represents the model behind the search form of `app\models\Laudo`.
 */
class LaudoSearch extends Laudo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_consulta'], 'integer'],
            [['oe', 'od', 'dp', 'lentes', 'observacoes', 'nova_consulta'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Laudo::find();

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
            'id_consulta' => $this->id_consulta,
            'nova_consulta' => $this->nova_consulta,
        ]);

        $query->andFilterWhere(['like', 'oe', $this->oe])
            ->andFilterWhere(['like', 'od', $this->od])
            ->andFilterWhere(['like', 'dp', $this->dp])
            ->andFilterWhere(['like', 'lentes', $this->lentes])
            ->andFilterWhere(['like', 'observacoes', $this->observacoes]);

        return $dataProvider;
    }
}
