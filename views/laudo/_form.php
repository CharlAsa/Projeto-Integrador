<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Laudo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="laudo-form">

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         <h4><i class="icon fa fa-check"></i>Saved!</h4>
         <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

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

    <?=
		
		$form->field($model, 'nova_consulta')->widget(DatePicker::className(), [
			'language' => 'pt',
			'options' => [
				'placeholder' => 'Escolha a data da consulta...',
				],
			'pluginOptions' => [
				'autoclose'=>true
			],
		])
		
	?>>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
