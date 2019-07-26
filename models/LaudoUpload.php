<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

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
    
    public function upload($id_consulta)
    {
        if($id_consulta == null){
            return false;
        }
        if ($this->validate()) {
            $nome = \Yii::$app->security->generateRandomString().$this->laudopdf->baseName.\Yii::$app->security->generateRandomString();
            $url ='../uploads/laudo/' . $nome . '.' . $this->laudopdf->extension;

            $laudo = Consulta::findOne(['id' => $id_consulta]);

            if($laudo->nomedoarquivo != null){
                $nome = $laudo->nomedoarquivo;
                $url ='../uploads/laudo/' . $nome . '.' . $this->laudopdf->extension;
                $this->laudopdf->saveAs($url);
                return true;
            }

            if($laudo->updateAttributes(['nomedoarquivo' => $nome]) > 0)
            {
                $this->laudopdf->saveAs($url);
                return true;
            }
        }
        return false;
    }
}