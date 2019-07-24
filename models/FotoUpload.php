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
    
    public function upload()
    {
        if ($this->validate()) {
            $url ='../uploads/fotos/' . \Yii::$app->security->generateRandomString() . $this->foto->baseName . \Yii::$app->security->generateRandomString() . '.' . $this->foto->extension;
            $this->foto->saveAs($url);
            return true;
        } else {
            return false;
        }
    }
}