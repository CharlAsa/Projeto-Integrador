<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class FotoUpload extends Model
{
    /**
     * @var UploadedFile
     */
    public $foto;

    public function rules()
    {
        return [
            [['foto'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }
    
    public function upload($id_medico)
    {
        if($id_medico == null){
            return false;
        }
        if ($this->validate()) {
            $nome = \Yii::$app->security->generateRandomString().$this->foto->baseName.\Yii::$app->security->generateRandomString();
            $url ='../uploads/fotos/' . $nome . '.' . $this->foto->extension;
            
            $usuario = Usuario::findOne(['id' => $id_medico]);

            if($usuario->nomedaassinatura != null){
                $nome = $usuario->nomedaassinatura;
                $url ='../uploads/fotos/' . $nome . '.' . $this->foto->extension;
                $this->foto->saveAs($url);
                return true;
            }

            if($usuario->updateAttributes(['nomedaassinatura' => $nome]) > 0){
                $this->foto->saveAs($url);
                return true;
            }
        }
        return false;
    }
}