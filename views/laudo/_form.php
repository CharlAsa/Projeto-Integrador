<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Laudo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="laudo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_consulta')->textInput() ?>

    <?= $form->field($model, 'oe')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'od')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'dp')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'lentes')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'observacoes')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'nova_consulta')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
