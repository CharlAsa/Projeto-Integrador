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
use yii\helpers\Html;
?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         <h4><i class="icon fa fa-check"></i>Sucesso!</h4>
         <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger alert-dismissable">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         <h4><i class="icon fa fa-check"></i>Erro!</h4>
         <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'foto')->fileInput() ?>

    <button>Submit</button>

<?php ActiveForm::end() ?>

<?php //echo '<img src="' . $foto . '" width="800px" height="600px">'; ?>

<?php if(Yii::$app->user->identity->nomedaassinatura != null) { ?>

<h2> Já fez o upload da assinatura se fazer novamente, vai sobrescrever, para acessar clique no botão abaixo: </h2>
<?= Html::a(Yii::t('app', 'Download'), ['download'], ['class' => 'btn btn-info']) ?>

<?php 
    //'../uploads/fotos/'.Yii::$app->user->identity->nomedaassinatura
    $foto = 'data: '.mime_content_type('../uploads/fotos/'.Yii::$app->user->identity->nomedaassinatura).';base64,'.base64_encode(file_get_contents('../uploads/fotos/'.Yii::$app->user->identity->nomedaassinatura));
    echo '<br>';
    echo '<h2> Assinatura atual: </h2>';
    echo '<img src="' . $foto . '" width="480px" height="240px">';
?>

<?php } else{ ?>
<h2> Ainda não fez o upload da assinatura, por favor faça o quanto antes. </h2>
<?php } ?>