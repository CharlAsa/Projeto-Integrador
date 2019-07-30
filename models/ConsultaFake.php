<?php

namespace app\models;

use Yii;

class ConsultaFake extends \yii\db\ActiveRecord
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
            [['id_paciente'], 'required'],
            [['id_paciente'], 'integer'],
            [['id_paciente'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_paciente' => 'id']],
		];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_paciente' => 'Id Paciente',
        ];
    }

    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaciente()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_paciente']);
    }
    
    /*
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
    */
}
