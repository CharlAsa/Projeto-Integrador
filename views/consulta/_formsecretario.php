<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use kartik\date\DatePicker;

//$v = 1;
/* @var $this yii\web\View */
/* @var $model app\models\Consulta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="consulta-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= 
		$form->field($model, 'id_medico')->widget(Select2::classname(), [
			'data' => $medico,
			'language' => 'pt',
			'options' => ['placeholder' => 'Selecione o médico...'],
			'pluginOptions' => [
				'allowClear' => true
			],
		])
		->label('Nome do Médico')
	?>

	<?= 
		$form->field($model, 'id_paciente')->widget(Select2::classname(), [
			'data' => $usuario,
			'language' => 'pt',
			'options' => ['placeholder' => 'Selecione o nome do paciente...'],
			'pluginOptions' => [
				'allowClear' => true
			],
		])
		->label('Nome do Paciente')
	?>


	
	
	<?=
		
		$form->field($model, 'data_consulta')->widget(DatePicker::className(), [			
			'language' => 'pt',
			'options' => [
				'placeholder' => 'Escolha a data da consulta...',
				'onchange'=>'
					var k = document.getElementById("affs");
					k.dataset.params =
					"{"
					+"\"param1\":"
					+"\""
					+$(this).val()
					+"\""
					+",\"param2\":3"
					+",\"param3\":"
					+"\""
					+$(this).val()
					+"\""
					+"}";	

					document.getElementById("affs").click();
				'
				],
			'pluginOptions' => [
				'autoclose'=>true
			]
		
		])
		
	?>
	
	<?php Pjax::begin(['timeout'=>false, 'id'=>'a']) ?>

	<?php if($v["op"] == 2){ ?>
	<?= $form->field($model, 'horario')
        ->dropDownList(
			$v["valor"]
            //['M' => 'Masculino', 'F' => 'Feminino', 'O' => 'Outro'],           // Flat array ('id'=>'label') or $items
            //['prompt'=>'']    // options
    ); ?>
	<?php } ?>

	<?= Html::a('', 
	['consulta/secretarioagendaconsulta'], [
	'data-method' => 'POST',
	'data-params' => [
		'param1' => 1,
		'param2' => 1,
	],
	'data-pjax' => 1,
	'id'=>'affs',
	]) ?>

	<?php Pjax::end() ?>
	
	<?php /* Html::radioList('nomedaclasse', [16, 42],
		['N' => 'Não-Reservado', 'M' => 'Manhã', 'T' => 'Tarde'],
		['onchange'=>'
			var radios = document.getElementsByName("nomedaclasse");

			for (var i = 0, length = radios.length; i < length; i++)
			{
				if (radios[i].checked)
				{
					var c = document.getElementById("consulta-horario");
					if(radios[i].value == \'M\'){
						c.readOnly = true;
						
						document.getElementById("consulta-horario").value = "07:59";
					}
					else if(radios[i].value == \'N\'){
						c.readOnly = false;
						
						document.getElementById("consulta-horario").value = "";
					}
					else if(radios[i].value == \'T\'){
						c.readOnly = true;
						
						document.getElementById("consulta-horario").value = "13:59";
					}
					
					document.getElementById("aff").click();
					
					break;
				}
			}
		',
		'id'=>'radiodafuq'],
		)
	*/?>	

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
	</div>		

    <?php ActiveForm::end(); ?>

	<?php Pjax::begin(['timeout'=>false, 'id'=>'a']) ?>

	<?php
		if($v["valor"] != null){
			if($v["op"] == 0){
				echo "<p> Numero de consultas:".$v["valor"]."</p>";
			}
			else{
				echo "<p> Resevado?";
					if($v["valor"] > 0){
						echo "Sim";
					}
					else{
						echo "Não";
					}
				echo "</p>";
			}
		}
	?>

	<?= Html::a('', 
	['consulta/secretarioagendaconsulta'], [
	'data-method' => 'POST',
	'data-params' => [
		'param1' => 1,
		'param2' => 1,
	],
	'data-pjax' => 1,
	'id'=>'aff',
	]) ?>
	
	<?php Pjax::end() ?>
	
</div>
