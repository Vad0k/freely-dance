<?php
use yii\helpers\Url;
?>
<?php $arraySlider = [['IMAGE'=>Yii::getAlias('@web/images/slider/2.jpg')], ['IMAGE'=>Yii::getAlias('@web/images/slider/5.jpg')],['IMAGE'=>Yii::getAlias('@web/images/slider/4.jpg')], ]; ?>
<section id="section-header-slider">
    <ul class="slider">
        <?php foreach($arraySlider as $item):?>
            <li style="background-image: url('<?=$item['IMAGE']?>')"></li>
        <?php endforeach;?>
    </ul>
    <div class="container">
        <div class="h1">
            <h1>Всё для танцев<br/> в Симферополе</h1>
            <div class="address">г. Симферополь, площадь Куйбышева, ул.Тренева 1, (2 этаж),<br /> (вход со стороны ул.Богдана Хмельницкого)</div>
        </div>

        <a href="<?=Url::to(['site/gallery'])?>" class="button btn-details no-select">ПОДРОБНО</a>
        <a href="<?=Url::to(['site/contacts'])?>" class="button btn-callback no-select">ОБРАТНАЯ СВЯЗЬ</a>
    </div>
</section>