<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Usuarios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$this->registerJs(
    "
		//setInterval(click, 1000);

		function click()
		{
			$('#vvv').click();
		}
	",
);

?>
<div class="usuario-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
	<?php Pjax::begin(['timeout'=>false, 'id'=>'a']) ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'cpf',
            'rg',
            'sexo',
            'nascimento',
            'data_cadastro',
            'username',
            'password',
            'auth_key_Yii',
            'access_token_Yii',
            'id_Yii',
			'nome',
        ],
    ]) ?>
		<?= Html::a("Show Time", ['usuario/view','id'=>$model->id], ['class' => 'btn btn-lg btn-primary', 'id'=>'vvv']) ?>
		<h1>It's: <?= $response ?></h1>
	<?php Pjax::end() ?>
</div>
