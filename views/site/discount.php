<?php /* VAD0K */
use yii\helpers\Url;
?>

<div id="product-list">
    <h1 class="title-section">Аукционные товары</h1>
    <div class="article">
        Дизайнерское ателье "Молонга", время от времени предоставляет своим покупателям, качественный товар по сезонным скидкам.
    </div>
    <?php foreach($arrayListProduct as $item):?>
        <a href="<?=Url::to(['site/product','id'=>$item['id']])?>" class="item">
            <div class="image" style="background-image: url('<?=$item['image']?>');"></div>
            <h2 class="title"><?=$item['title']?></h2>
            <div class="panel">
                <div class="price">Цена: <?=number_format($item['price'],0,'',' ')?> руб.</div>
                <div class="basket">&#128722</div>
            </div>
        </a>
    <?php endforeach;?>
    <div class="clear"></div>
</div>
