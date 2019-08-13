<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clinica".
 *
 * @property int $idclinica
 * @property string $nome
 * @property string $especialidade
 * @property string $logradouro
 * @property string $bairro
 * @property string $cidade
 * @property string $numero
 * @property string $email
 * @property string $telefone
 */
class Clinica extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clinica';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'especialidade', 'logradouro', 'bairro', 'cidade', 'email', 'telefone'], 'string', 'max' => 45],
            [['numero'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idclinica' => Yii::t('app', 'Idclinica'),
            'nome' => Yii::t('app', 'Nome'),
            'especialidade' => Yii::t('app', 'Especialidade'),
            'logradouro' => Yii::t('app', 'Logradouro'),
            'bairro' => Yii::t('app', 'Bairro'),
            'cidade' => Yii::t('app', 'Cidade'),
            'numero' => Yii::t('app', 'Numero'),
            'email' => Yii::t('app', 'Email'),
            'telefone' => Yii::t('app', 'Telefone'),
        ];
    }
}
