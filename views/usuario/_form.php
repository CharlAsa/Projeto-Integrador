<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($model, 'nome')->textInput(['maxlength' => true])->label('Nome') ?>

    <?= $form->field($model, 'cpf')->textInput(['maxlength' => 11])->label('CPF') ?>

    <?= $form->field($model, 'rg')->textInput(['maxlength' => true])->label('RG') ?>

	<?= $form->field($model, 'sexo')
        ->dropDownList(
            ['M' => 'Masculino', 'F' => 'Feminino', 'O' => 'Outro'],           // Flat array ('id'=>'label') or $items
            //['prompt'=>'']    // options
        ); ?>
	
	<?= $form->field($model, 'nascimento')->widget(\yii\widgets\MaskedInput::className(), [
    'mask' => '99/99/9999'])->label('Data do Nascimento') ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true])->label('Login') ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('Senha') ?>


	<?= $form->field($model2, 'numero_telefone')->textarea(['rows' => 6]) ?>

    <?= $form->field($model2, 'email')->textarea(['rows' => 6]) ?>


	<?= $form->field($model3, 'logradouro')->textarea(['rows' => 6]) ?>

    <?= $form->field($model3, 'bairro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model3, 'cidade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model3, 'uf')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model3, 'cep')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model3, 'numero_casa')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
