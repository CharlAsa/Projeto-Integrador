<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuario;

/**
 * UsuarioSearch represents the model behind the search form of `app\models\Usuario`.
 */
class UsuarioSearch extends Usuario
{

    //CAMPO DE PESQUISA VIRTUAL
    //Compo Contato
    public $numerotelefone;
    public $email;

    //Campo Endereco
    public $logradouro;
    public $bairro;
    public $cidade;
    public $uf;
    public $cep;
    public $numerocasa;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_Yii'], 'integer'],
            [['cpf', 'rg', 'sexo', 'nascimento', 'data_cadastro', 'username', 'password', 'auth_key_Yii', 'access_token_Yii', 'nome'], 'safe'],

            //CAMPO DE PESQUISA VIRTUAL
            [['numerotelefone', 'numerocasa'], 'string'],
            [['email','logradouro', 'bairro', 'cidade', 'uf', 'cep',], 'safe'],
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
        $query = Usuario::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['numerotelefone'] = [
            'asc' => ['contato.numero_telefone' => SORT_ASC],
            'desc' => ['contato.numero_telefone' => SORT_DESC],
            'default' => SORT_ASC
        ];

        $dataProvider->sort->attributes['email'] = [
            'asc' => ['contato.email' => SORT_ASC],
            'desc' => ['contato.email' => SORT_DESC],
            'default' => SORT_ASC
        ];
        //Endereço
        $dataProvider->sort->attributes['logradouro'] = [
            'asc' => ['endereco.logradouro' => SORT_ASC],
            'desc' => ['endereco.logradouro' => SORT_DESC],
            'default' => SORT_ASC
        ];

        $dataProvider->sort->attributes['bairro'] = [
            'asc' => ['endereco.bairro' => SORT_ASC],
            'desc' => ['endereco.bairro' => SORT_DESC],
            'default' => SORT_ASC
        ];
        $dataProvider->sort->attributes['cidade'] = [
            'asc' => ['endereco.cidade' => SORT_ASC],
            'desc' => ['endereco.cidade' => SORT_DESC],
            'default' => SORT_ASC
        ];
        $dataProvider->sort->attributes['uf'] = [
            'asc' => ['endereco.uf' => SORT_ASC],
            'desc' => ['endereco.uf' => SORT_DESC],
            'default' => SORT_ASC
        ];
        $dataProvider->sort->attributes['cep'] = [
            'asc' => ['endereco.cep' => SORT_ASC],
            'desc' => ['endereco.cep' => SORT_DESC],
            'default' => SORT_ASC
        ];

        $dataProvider->sort->attributes['numerocasa'] = [
            'asc' => ['endereco.numero_casa' => SORT_ASC],
            'desc' => ['endereco.numero_casa' => SORT_DESC],
            'default' => SORT_ASC
        ];


        //CAMPO DE PESQUISA VIRTUAL
        $query->joinWith(['contatos']);
        $query->joinWith(['enderecos']);


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'nascimento' => $this->nascimento,
            'data_cadastro' => $this->data_cadastro,
            'id_Yii' => $this->id_Yii,
        ]);

        $query->andFilterWhere(['like', 'cpf', $this->cpf])
            ->andFilterWhere(['like', 'rg', $this->rg])
            ->andFilterWhere(['like', 'sexo', $this->sexo])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'auth_key_Yii', $this->auth_key_Yii])
            ->andFilterWhere(['like', 'access_token_Yii', $this->access_token_Yii])
			->andFilterWhere(['like', 'nome', $this->nome]);

        //CAMPO DE PESQUISA VIRTUAL
        $query->joinWith(['contatos' => function ($q) {
            $q->where('contato.numero_telefone LIKE "%' . $this->numerotelefone . '%"');
        }]);

        $query->joinWith(['contatos' => function ($q) {
            $q->where('contato.email LIKE "%' . $this->email . '%"');
        }]);

        $query->joinWith(['enderecos' => function ($q) {
            $q->where('endereco.logradouro LIKE "%' . $this->logradouro . '%"');
        }]);

        $query->joinWith(['enderecos' => function ($q) {
            $q->where('endereco.bairro LIKE "%' . $this->bairro . '%"');
        }]);
        $query->joinWith(['enderecos' => function ($q) {
            $q->where('endereco.cidade LIKE "%' . $this->cidade . '%"');
        }]);
        $query->joinWith(['enderecos' => function ($q) {
            $q->where('endereco.uf LIKE "%' . $this->uf . '%"');
        }]);
        $query->joinWith(['enderecos' => function ($q) {
            $q->where('endereco.cep LIKE "%' . $this->cep . '%"');
        }]);

        $query->joinWith(['enderecos' => function ($q) {
            $q->where('endereco.numero_casa LIKE "%' . $this->numerocasa . '%"');
        }]);


        return $dataProvider;
    }
}
