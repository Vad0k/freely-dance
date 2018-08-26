<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товар';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="model-products-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать продукт', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'category_id',
            //'head_title',
            //'head_description',
            //'head_keywords',
            'title',
            'image:ntext',
            'product_code',
            'description:ntext',
            'description_more:ntext',
            'price',
            // 'params',
            // 'isFavorite',
            // 'isNew',
            // 'isVisible',
            // 'views',
            // 'similar',
            // 'time_created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
