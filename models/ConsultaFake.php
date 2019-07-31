<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ConsultaFake extends \yii\db\ActiveRecord
{
    public $id_paciente;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_paciente'], 'required'],
            [['id_paciente'], 'integer'],
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
}