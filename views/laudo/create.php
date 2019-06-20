<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Laudo */

$this->title = Yii::t('app', 'Create Laudo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Laudos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="laudo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
