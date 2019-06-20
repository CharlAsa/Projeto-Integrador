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
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_paciente', 'id_medico'], 'integer'],
            [['data_consulta', 'estado', 'horario'], 'safe'],
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
    public function search($params, $con = null)
    {
        $query = Consulta::find();

        // add conditions that should always apply here
        /*
        if($con != null){
            $id = Yii::$app->user->identity->id;
            $query->innerJoin('medico','medico.id_usuario=consulta.id')
            ->innerJoin('usuario','usuario.id=medico.id_usuario')
            ->where('usuario.id='.$id)
            ->select('usuario.cpf, consulta.*')
            //->distinct()
            ;
        }
        */

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
            'id_paciente' => $this->id_paciente,
            'id_medico' => $this->id_medico,
            'data_consulta' => $this->data_consulta,
        ]);

        $query->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider;
    }
}
