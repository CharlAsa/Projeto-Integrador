<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

require_once('../PDF/index.php');

class LaudoUpload extends Model
{
    /**
     * @var UploadedFile
     */
    public $laudopdf;

    public function rules()
    {
        return [
            [['laudopdf'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'laudopdf' => 'PDF do Laudo',
        ];
    }
    
    public function upload($id_consulta)
    {
        if($id_consulta == null){
            return false;
        }
        if ($this->validate()) {
            $nome = \Yii::$app->security->generateRandomString().$this->laudopdf->baseName.\Yii::$app->security->generateRandomString() . '.' . $this->laudopdf->extension;
            $url ='../uploads/laudo/' . $nome;

            $laudo = Consulta::findOne(['id' => $id_consulta]);
            $paciente = Usuario::find()->limit(1)->where(["id" => $laudo->id_paciente])->one();
			$paciente->updateAttributes(['agendamento_consulta' => '1']);

            $laudo->updateAttributes(['estado' => 'r', 'dataUpload' => new \yii\db\Expression('NOW()')]);
            
            if($laudo->nomedoarquivo != null){
                $nome = $laudo->nomedoarquivo;
                $url ='../uploads/laudo/' . $nome;

                $this->laudopdf->saveAs($url);

                $assinatura = $laudo->medico->nomedaassinatura;
                if($assinatura != null){
                    JuntarAssinaturaLaudo($nome, $assinatura);
                }


                return true;
            }

            if($laudo->updateAttributes(['nomedoarquivo' => $nome]) > 0)
            {
                $this->laudopdf->saveAs($url);

                $assinatura = $laudo->medico->nomedaassinatura;
                if($assinatura != null){
                    JuntarAssinaturaLaudo($nome, $assinatura);
                }

                return true;
            }
        }
        return false;
    }
}