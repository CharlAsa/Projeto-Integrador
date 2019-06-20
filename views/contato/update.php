<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Contato */

$this->title = Yii::t('app', 'Update Contato: {name}', [
    'name' => $model->id_usuario,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contatos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_usuario, 'url' => ['view', 'id' => $model->id_usuario]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="contato-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
