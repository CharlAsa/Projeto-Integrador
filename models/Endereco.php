<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "endereco".
 *
 * @property int $id_usuario
 * @property string $logradouro
 * @property string $bairro
 * @property string $cidade
 * @property string $uf
 * @property string $cep
 * @property string $numero_casa
 *
 * @property Usuario $usuario
 */
class Endereco extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'endereco';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'logradouro', 'bairro', 'cidade', 'uf', 'cep', 'numero_casa'], 'required'],
            [['id_usuario'], 'integer'],
            [['logradouro'], 'string'],
            [['bairro', 'cidade'], 'string', 'max' => 20],
            [['uf'], 'string', 'max' => 2],
            [['cep'], 'string', 'max' => 7],
            [['numero_casa'], 'string', 'max' => 4],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_usuario' => 'Id Usuario',
            'logradouro' => 'Logradouro',
            'bairro' => 'Bairro',
            'cidade' => 'Cidade',
            'uf' => 'Uf',
            'cep' => 'Cep',
            'numero_casa' => 'Numero Casa',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_usuario']);
    }
	
	public static function primaryKey()
	{

		return ['id_usuario'];

		// For composite primary key, return an array like the following

		//return array('id_usuario', 'infacao_id');

	}
}
