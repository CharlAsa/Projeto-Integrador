<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Laudo */

$this->title = Yii::t('app', 'Update Laudo: {name}', [
    'name' => $model->id_consulta,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Laudos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_consulta, 'url' => ['view', 'id' => $model->id_consulta]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="laudo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
