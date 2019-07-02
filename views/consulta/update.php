<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Consulta */

$this->title = Yii::t('app', 'Update Consulta: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Consultas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="consulta-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if($medico != null){ ?>
        <?= $this->render('_formsecretario', [
            'model' => $model,
            'usuario' => $usuario,
            'v' => $v,
            'medico' => $medico,
        ]) ?>
    <?php }
    else{ ?>
        <?= $this->render('_form', [
            'model' => $model,
            'usuario' => $usuario,
            'v' => $v,
        ]) ?>
    <?php } ?>

</div>
