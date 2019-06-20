<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Secretario */

$this->title = Yii::t('app', 'Create Secretario');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Secretarios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="secretario-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
