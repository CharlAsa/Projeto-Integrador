<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "consulta".
 *
 * @property int $id
 * @property int $id_paciente
 * @property int $id_medico
 * @property string $data_consulta
 * @property string $estado
 *
 * @property Paciente $paciente
 * @property Medico $medico
 * @property Laudo[] $laudos
 */
class Consulta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'consulta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_paciente', 'id_medico'], 'required'],
            [['id_paciente', 'id_medico'], 'integer'],
            [['data_consulta'], 'safe'],
            [['estado'], 'string', 'max' => 1],
            [['id_paciente'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_paciente' => 'id']],
            [['id_medico'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_medico' => 'id']],
            [['horario'], 'string', 'max' => 5],
		];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_paciente' => 'Id Paciente',
            'id_medico' => 'Id Medico',
            'data_consulta' => 'Data Consulta',
            'estado' => 'Estado',
            'horario' => 'Hora da consulta',
            'paciente.nome' => 'Nome do Paciente',
            'medico.nome' => 'Nome do Médico',
        ];
    }

    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaciente()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_paciente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedico()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_medico']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLaudos()
    {
        return $this->hasMany(Laudo::className(), ['id_consulta' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLaudo()
    {
        return $this->hasOne(Laudo::className(), ['id_consulta' => 'id']);
    }
	
	public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            //if ($this->isNewRecord) {
				$this->data_consulta = str_replace('/', '-', $this->data_consulta);
				$this->data_consulta = date("Y-m-d", strtotime($this->data_consulta));
				//Yii::trace($this->nascimento);
				//$this->id_Yii = 1;
            //}
            return true;
        }
        return false;
    }
}
