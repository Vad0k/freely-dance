<?php
use yii\bootstrap\Nav;
use yii\helpers\Url;
/*
$arrayItems = [];
foreach($arrayCategory as $item){
    $url = '';
    if ($item['type'] == 'CATEGORY') {
        $url = Url::to(['site/category','id'=>$item['id']]);
    } else if ($item['type'] == 'SUB-CATEGORY') {
        $url = Url::to(['site/category','id'=>$item['id']]);
    } else if ($item['type'] == 'PRODUCT') {
        $url = Url::to(['site/product-list','id'=>$item['id']]);
    } else if($item['type'] == 'PAGE'){
        $url = Url::to([$item['url']]);
    } else {
        $url = '/';
    }

    $arrayItems[] = ['label'=>$item['label'], 'url'=>$url,'linkOptions'=>['role'=>'menuitem']];
}*/
//arrayCategory
?>

<!-- ШАПКА САЙТА -->
<header id="header">
    <div class="container">
        <div class="top">
            <img src="<?=Yii::getAlias('@web/images/logo.png')?>" alt="Нарядница - одежда для танцев" class="logo" height="115">
            <strong class="title">Всё, что необходимо<br />для танца</strong>
            <div class="col">
                <a class="basket" href="<?=Url::to(['/basket/show'])?>">
                    <div>Ваша корзина</div>
                    <small class="count" data-url="<?=Url::to(['/basket/get-count-product'])?>"><?=isset($session['basket']) ? count($session['basket']) : 0?> товаров на сумму <?=number_format(isset($session['basket.count']) ? $session['basket.count'] : 0, 0, '', ' ')?> руб.</small>
                </a>
                <div class="phones">
                    <a href="tel:80996611783">8 (099) 661-17-83</a>
                    <a href="tel:80996611783">8 (099) 661-17-83</a>
                </div>
            </div>
            <div class="social">
                <a href="<?=Url::to(['/site/reg'])?>" class="reg">Регистрация</a>
                <a href="<?=Url::to(['/site/auth'])?>" class="auth">Войти</a>
                <a href="" class="icon vk"></a>
                <a href="" class="icon fb"></a>
                <a href="" class="icon in"></a>
                <a href="" class="icon vb"></a>
            </div>
        </div>
        <nav class="nav">
            <?=Nav::widget(['items'=>[
                [
                    'label'=>'Главная',
                    'url'=>['/site/index'],
                    'linkOptions'=>['role'=>'menuitem']
                ],
                [
                    'label'=>'Как выбрать пуанты?',
                    'url'=>['/site/kak-vibrat-puanti'],
                    'linkOptions'=>['role'=>'menuitem']
                ],
                [
                    'label'=>'Каталог',
                    'url'=>['/site/category'],
                    'linkOptions'=>['role'=>'menuitem'],
                    'linkOptions'=>['class'=>'sub-menu'],
                    'items'=>[
                        [
                            'label'=>'Аксессуары',
                            'url'=>['/site/catalog/1'],
                            'linkOptions'=>['role'=>'menuitem']
                        ],
                        [
                            'label'=>'Пуанты',
                            'url'=>['/site/catalog/2'],
                            'linkOptions'=>['role'=>'menuitem']
                        ],
                        [
                            'label'=>'Гимнастическая',
                            'url'=>['/site/catalog/3'],
                            'linkOptions'=>['role'=>'menuitem']
                        ],
                        [
                            'label'=>'Джазовки',
                            'url'=>['/site/catalog/4'],
                            'linkOptions'=>['role'=>'menuitem']
                        ],
                        [
                            'label'=>'Чешки',
                            'url'=>['/site/catalog/5'],
                            'linkOptions'=>['role'=>'menuitem']
                        ],

                    ]
                ],
                [
                    'label'=>'Оплата',
                    'url'=>['/site/kak-vibrat-puanti'],
                    'linkOptions'=>['role'=>'menuitem']
                ],
                [
                    'label'=>'Отзывы',
                    'url'=>['/site/kak-vibrat-puanti'],
                    'linkOptions'=>['role'=>'menuitem']
                ],
                [
                    'label'=>'Контакты',
                    'url'=>['/site/kak-vibrat-puanti'],
                    'linkOptions'=>['role'=>'menuitem']
                ],
            ]]);?>
        </nav>
        <img src="<?=Yii::getAlias('@web//images/main-girl.svg')?>" alt="Одежда для танцев" height="451" class="girl" />
    </div>
</header>
<!-- ШАПКА САЙТА -->