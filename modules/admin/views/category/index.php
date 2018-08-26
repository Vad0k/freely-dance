<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Создать категорию';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="model-category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'parent_id',
            //'label_en',
            'label',
            'type',
            // 'image:ntext',
            // 'position',
            // 'bgSize',
            // 'description',
            // 'article:ntext',
            // 'head_title',
            // 'head_description',
            // 'head_keywords',
            // 'url:ntext',
            // 'visible',
            'sort',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
