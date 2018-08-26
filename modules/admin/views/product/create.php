<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ModelProducts */

$this->title = 'Создать "товар"';
$this->params['breadcrumbs'][] = ['label' => 'Товар', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="model-products-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
