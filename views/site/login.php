<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1 class="sign" align="center"><?= Html::encode($this->title) ?></h1>

    <!-- <p>Please fill out the following fields to login:</p> -->

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'username', ['options'=>['style' => 'align="center"']])->textInput(['autofocus' => true, 'placeholder' => "Digite seu usuário"])->label(false) ?>

        <?= $form->field($model, 'password', ['options'=>['style' => 'align="center"']])->passwordInput(['placeholder' => "Digite sua senha"])->label(false) ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label} <div class='fudeu'> <a class='cadastrarpacientes' href='".Url::toRoute(['usuario/cadastrar'])."'> Cadastrar </a> </div> </div>\n<div class=\"col-lg-8\">{error}</div>",
        ])->label(Yii::t('app', 'Remember-me')) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Logar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>
