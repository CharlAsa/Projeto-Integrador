<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Consulta */

//$this->title = $model->id;
$this->title = "Consulta";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Consultas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="consulta-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if(Yii::$app->user->identity->id_Yii == 1 || Yii::$app->user->identity->id_Yii == 4){ ?>
        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php } ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'paciente.nome',
            'medico.nome',
            'data_consulta',
            [
                'attribute' => 'estado',
                'value' => ($model->estado == 'a') ? ("Agendado") : (($model->estado == 'r') ? ("Realizado") : ("Cancelado")),
            ],
        ],
    ]) ?>

    <?php if($model->nomedoarquivo != null) { ?>

        <h2> Laudo já disponível, clique no botão abaixo para fazer download: </h2>
        <?= Html::a(Yii::t('app', 'Download'), ['download', 'id_consulta' => $model->id], ['class' => 'btn btn-info']) ?>

    <?php } else{ ?>
        <h2> Laudo não disponível para download ou a consulta ainda não foi realizada. </h2>
    <?php } ?>

</div>
