<?php
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'laudopdf')->fileInput() ?>

    <button>Submit</button>

<?php ActiveForm::end() ?>