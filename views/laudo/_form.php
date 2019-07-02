<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Laudo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="laudo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_consulta')->
        widget(Select2::classname(), [
            //'data' => $arraySecao,
            'data' => $arrayUsuario,
            'options' => ['placeholder' => Yii::t('app','Selecione o paciente que deseja ...')],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

    <?= $form->field($model, 'oe')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'od')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lentes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'observacoes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nova_consulta')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
