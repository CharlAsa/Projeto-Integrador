<?php
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

//$url = '../uploads/fotos/3EEovJhGj6lPl9GUIoLATnyh6Hnmyem2bug2ZB67dMmqQp_a5i63HUm1aXZntOnLqyW.png';
//$foto = UploadedFile::getInstanceByName('../uploads/fotos/3EEovJhGj6lPl9GUIoLATnyh6Hnmyem2bug2ZB67dMmqQp_a5i63HUm1aXZntOnLqyW.png');
//yii::trace($foto);

//if (file_exists($url)) {
//    $foto = Yii::$app->response->sendFile($url);
    //$Vdata = file_get_contents($url);
    //yii::trace($Vdata);
    //$imageData = base64_encode(file_get_contents($url));
    //$foto = 'data: '.mime_content_type($url).';base64,'.$imageData;
//}
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'foto')->fileInput() ?>

    <button>Submit</button>

<?php ActiveForm::end() ?>

<?php //echo '<img src="' . $foto . '" width="800px" height="600px">'; ?>