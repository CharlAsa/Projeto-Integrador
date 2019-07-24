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
    
    public function upload()
    {
        if ($this->validate()) {
            $url ='../uploads/laudo/' . \Yii::$app->security->generateRandomString() . $this->laudopdf->baseName . \Yii::$app->security->generateRandomString() . '.' . $this->laudopdf->extension;
            $this->laudopdf->saveAs($url);
            return true;
        } else {
            return false;
        }
    }
}