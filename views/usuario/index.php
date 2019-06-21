<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Usuarios');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Usuario'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'cpf',
            'rg',
            'sexo',
            'nascimento',
            //'data_cadastro',
            //'username',
            //'password',
            //'auth_key_Yii',
            //'access_token_Yii',
            //'id_Yii',
            [
                'attribute' => 'numerotelefone',
                'label' => 'Número Telefone',
                //'format' => 'raw',
                'value' => function($data){
                    //return Html::a(Escoteiro::getContatoTelefone($data->idescoteiro), ['site/index']);

                    return Usuario::getContatoTelefone($data->id);
                },
            ],
            [
                'attribute' => 'email',
                'label' => 'E-mail',
                'value' => function($data){
                    return Usuario::getContatoEmail($data->id);
                },
            ],

            [
                'attribute' => 'logradouro',
                'label' => 'Logradouro',
                'value' => function($data){
                    return Usuario::getEnderecoLogradouro($data->id);
                },
            ],
            
            [
                'attribute' => 'bairro',
                'label' => 'Bairro',
                'value' => function($data){
                    return Usuario::getEnderecoBairro($data->id);
                },
            ],

            [
                'attribute' => 'numerocasa',
                'label' => 'Número da Casa',
                'value' => function($data){
                    return Usuario::getEnderecoNumeroCasa($data->id);
                },
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
