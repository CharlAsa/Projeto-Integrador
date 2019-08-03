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
            <?= Html::a(Yii::t('app', 'Agendar consulta'), ['consulta/medicoagendaconsulta'], ['class' => 'btn btn-success']) ?>
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

            ['class' => 'yii\grid\ActionColumn','template'=>'{atualizar} {ver} {deletar} {upload}',
            'buttons'  => [
            'atualizar' => function ($url,$model,$key) {
                return Html::a('<span class="glyphicon glyphicon-edit"></span>', ['consulta/update', 'id'=>$model->id], ['title'=>Yii::t('app','Atualizar')]);
            },
            'ver' => function ($url,$model,$key) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['consulta/view', 'id'=>$model->id], ['title'=>Yii::t('app','Ver')]);
            },
            'deletar' => function ($url,$model,$key){
                return Html::a('<span class="glyphicon glyphicon-remove-sign"></span>', ['consulta/delete', 'id'=>$model->id], ['data-confirm'=>Yii::t('app', 'Tem certeza que deseja remover esse laudo?'), 'title'=>Yii::t('app', 'Remove'), 'data-method'=>'post']);
            },
            'upload' => function ($url,$model,$key) {
                return Html::a('<span class="glyphicon glyphicon-paperclip"></span>', ['consulta/laudoupload', 'id'=>$model->id], ['title'=>Yii::t('app','Upload')]);
            },
            //'leadDelete' => function ($url, $model) {
            //	$url = Url::to(['datakegiatan/delete', 'id' => $model->ID_DATA]);
            //	return Html::a('<span class="fa fa-trash"></span>', $url, [
            //		'title'        => 'delete',
            //		'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            //		'data-method'  => 'post',
            //]
            ]],
        ],
    ]); ?>


</div>
