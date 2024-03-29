<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ConsultaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
Yii::trace($dataProvider);
$this->title = Yii::t('app', 'Consultas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consulta-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Consulta'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_paciente',
            'id_medico',
            'data_consulta',
            'estado',
            'nome',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>