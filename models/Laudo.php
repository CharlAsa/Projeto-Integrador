<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "laudo".
 *
 * @property int $id_consulta
 * @property string $oe
 * @property string $od
 * @property string $dp
 * @property string $lentes
 * @property string $observacoes
 * @property string $nova_consulta
 *
 * @property Consulta $consulta
 */
class Laudo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'laudo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_consulta'], 'integer'],
            [['oe', 'od', 'dp', 'lentes', 'observacoes'], 'string'],
            [['nova_consulta'], 'safe'],
            [['id_consulta'], 'exist', 'skipOnError' => true, 'targetClass' => Consulta::className(), 'targetAttribute' => ['id_consulta' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_consulta' => 'Id Consulta',
            'oe' => 'Olho esquerdo',
            'od' => 'Olho direito',
            'dp' => 'Dp',
            'lentes' => 'Lentes',
            'observacoes' => 'Observações',
            'nova_consulta' => 'Data da Nova Consulta',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsulta()
    {
        return $this->hasOne(Consulta::className(), ['id' => 'id_consulta']);
    }
	
	public static function primaryKey()
	{

		return ['id_consulta'];

		// For composite primary key, return an array like the following

		//return array('id_usuario', 'infacao_id');

	}
}
