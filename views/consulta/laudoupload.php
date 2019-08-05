<?php
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;
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

    <?= $form->field($model, 'laudopdf')->fileInput() ?>

    <button class="btn btn-primary">Enviar</button>

<?php ActiveForm::end() ?>