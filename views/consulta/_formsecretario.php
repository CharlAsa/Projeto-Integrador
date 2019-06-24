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

	<!-- pjax aqui -->

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

    <!-- $form->field($model, 'data_consulta')->widget(\yii\widgets\MaskedInput::className(), [
    'mask' => '99/99/9999',
	'options' => [
			'onchange'=>'
				var k = document.getElementById("aff");
				k.dataset.params =
				"{"
				+"\"param1\":"
				+"\""
				+$(this).val()
				+"\""
				+",\"param2\":2"
				+"}";
				
				document.getElementById("aff").click();
			'
		]
	])
	->label('Data da consulta') -->
	
	
	<?=
		
		$form->field($model, 'data_consulta')->widget(DatePicker::className(), [
		
			//'model' => $model, 
			//'attribute' => 'data_consulta',
			//'type' => DatePicker::TYPE_INPUT,
			
			'language' => 'pt',
			'options' => [
				'placeholder' => 'Escolha a data da consulta...',
				'onchange'=>'
					var k = document.getElementById("aff");
					k.dataset.params =
					"{"
					+"\"param1\":"
					+"\""
					+$(this).val()
					+"\""
					+",\"param2\":2"
					+"}";
					
					document.getElementById("aff").click();
				'
				],
			'pluginOptions' => [
				'autoclose'=>true
			]
		
		])
		
	?>
	
	<?= $form->field($model, 'horario')->widget(\yii\widgets\MaskedInput::className(), [
    //'mask' => 'hh:mm'])
	'mask' => 'h:m',
		'definitions'=>[
			'h'=>[
				'cardinality'=>2,
				'prevalidator' => [
					['validator'=>'^([0-2])$', 'cardinality'=>1],
					['validator'=>'^([0-9]|0[0-9]|1[0-9]|2[0-3])$', 'cardinality'=>2],
				],
				'validator'=>'^([0-9]|0[0-9]|1[0-9]|2[0-3])$'
			],
			'm'=>[
				'cardinality'=>2,
				'prevalidator' => [
					['validator'=>'^(0|[0-5])$', 'cardinality'=>1],
					['validator'=>'^([0-5]?\d)$', 'cardinality'=>2],
				]
			]
		],
		'options' => [
			'onchange'=>'
				var k = document.getElementById("aff");
				k.dataset.params =
				"{"
				+"\"param1\":"
				+"\""
				+$(this).val().replace(":",".")
				+"\""
				+",\"param2\":2"
				+"}";
				
				document.getElementById("aff").click();
			'
		]
		])
	->label('Horario da consulta') ?>
	
	<?= Html::radioList('nomedaclasse', [16, 42],
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
		'id'=>'radiodafuq']
		)
	?>	

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
	['consulta/medicoagendaconsulta'], [
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
