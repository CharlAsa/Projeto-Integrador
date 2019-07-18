<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ConsultaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Lista das consultas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consulta-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php  
            if(Yii::$app->user->isGuest == false){ if(Yii::$app->user->identity->id_Yii != 2){
        ?>
            <?= Html::a(Yii::t('app', 'Agendar consulta'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php }}  ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Nome do Paciente',
                'format' => 'ntext',
                'attribute'=>'nome',
                'value' => function($model) {
                    return $model->paciente->nome;
                },
            ],

            [
                'label' => 'Nome do Médico',
                'format' => 'ntext',
                'attribute'=>'nome',
                'value' => function($model) {
                    return $model->medico->nome;
                },
            ],
            'data_consulta',
            'horario',
            'estado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
