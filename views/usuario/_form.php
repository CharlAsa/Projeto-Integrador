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

    <?= yii\base\View::render('@app/views/endereco/_endereco.php', ['model' => $arrayEndereco, 'form' => $form]) ?>

    <?= yii\base\View::render('@app/views/contato/_contato.php', ['model' => $arrayContato, 'form' => $form]) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
