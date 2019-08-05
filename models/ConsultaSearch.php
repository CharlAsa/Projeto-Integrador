<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Consulta;
use app\models\Usuario;

/**
 * ConsultaSearch represents the model behind the search form of `app\models\Consulta`.
 */
class ConsultaSearch extends Consulta
{
    public $nome;
    public $nomemedico;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_paciente', 'id_medico'], 'integer'],
            [['data_consulta', 'estado', 'horario', 'nome', 'nomemedico'], 'safe'],
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
        $query = Consulta::find()
        ->innerJoin('usuario', 'usuario.id=consulta.id_paciente');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['attributes' => ['nome', 'nomemedico', 'data_consulta', 'estado']],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_paciente' => $this->id_paciente,
            'id_medico' => $this->id_medico,
            'data_consulta' => $this->data_consulta,
        ]);

        if(strlen($this->estado)<1){
            $query->andFilterWhere(['like', 'estado', $this->estado]);
        }
        else{
            $query->andFilterWhere(['like', 'estado', $this->estado[0]]);
        }
        $query->andFilterWhere(['like', 'nome', $this->nome])
        ->andFilterWhere(['like', 'nome', $this->nomemedico]);

        if(!Yii::$app->user->isGuest){
            $id = Yii::$app->user->identity->id_Yii;
            if($id == 4)
            {
                $query->andFilterWhere(['id_medico' => Yii::$app->user->identity->id]);
            }
            else if($id == 2){
                $query->andFilterWhere(['id_paciente' => Yii::$app->user->identity->id]);
            }
        }

        return $dataProvider;
    }
}
