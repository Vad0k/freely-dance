<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ModelProducts */

$this->title = 'Изменение модели товара: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Товар', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="model-products-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
