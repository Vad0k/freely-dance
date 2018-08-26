<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ModelCategory */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Категория', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="model-category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить данную категорию?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'parent_id',
            'label_en',
            'label',
            'type',
            'image:ntext',
            'position',
            'bgSize',
            'description',
            'article:ntext',
            'head_title',
            'head_description',
            'head_keywords',
            'url:ntext',
            'visible',
            'sort',
        ],
    ]) ?>

</div>
