<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
$model2->crm = '0';
?>

<div class="usuario-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($model, 'nome')->textInput(['maxlength' => true])->label('Nome') ?>

    <?= $form->field($model, 'cpf')->textInput(['maxlength' => 11])->label('CPF') ?>

    <?= $form->field($model, 'rg')->textInput(['maxlength' => true])->label('RG') ?>

	<?= $form->field($model, 'sexo')
        ->dropDownList(
            ['M' => 'Masculino', 'F' => 'Feminino', 'O' => 'Outro']           // Flat array ('id'=>'label') or $items
            //['prompt'=>'']    // options
        ); ?>
	
	<?= $form->field($model, 'nascimento')->widget(\yii\widgets\MaskedInput::className(), [
    'mask' => '99/99/9999'])->label('Data do Nascimento') ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true])->label('Login') ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('Senha') ?>

    <?= yii\base\View::render('@app/views/endereco/_endereco.php', ['model' => $arrayEndereco, 'form' => $form]) ?>

    <?= yii\base\View::render('@app/views/contato/_contato.php', ['model' => $arrayContato, 'form' => $form]) ?>

    <?= $form->field($model, 'id_Yii')
        ->dropDownList(
            ['1' => 'Secretario', '2' => 'Paciente', '4' => 'Doutor'],           // Flat array ('id'=>'label') or $items
            //['prompt'=>'']    // options
            ['onchange'=>'
                if($(this).val() == 4){
                    document.getElementsByClassName("field-medico-crm required")[0].style.visibility = "visible";
                    document.getElementById("medico-crm").value = "";
                }
                else{
                    document.getElementsByClassName("field-medico-crm required")[0].style.visibility = "hidden";
                    document.getElementById("medico-crm").value = "0";
                }
            ']
        )->label('Tipo de Usuário');
    ?>

    <?= $form->field($model2, 'crm', [ 'options' => [ 'style' => 'visibility: hidden;']])->textInput(['maxlength' => true])->label('CRM') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
