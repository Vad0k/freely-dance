<?php
use \yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
?>
<!-- ПОДВАЛ САЙТА -->
<footer id="footer">
    <div class="container">
        <nav class="nav">
            <a href="<?=Url::to(['site/news'])?>">Новости</a>
            <a href="<?=Url::to(['site/about'])?>">О Нас</a>
            <a href="<?=Url::to(['site/gallery'])?>">Фотогалерея</a>
            <a href="<?=Url::to(['site/partners'])?>">Партнеры</a>
            <a href="<?=Url::to(['site/kak-opredelit-razmer-obuvi'])?>">Как определить размер обуви</a>
        </nav>
        <div class="row-center">
            <?php $form = ActiveForm::begin([
                'method'=>'post',
                'action'=>Url::to(['site/get-contacts']),
                'id'=>'form-get-contacts',
                'options' => [
                    'class' => 'form'
                ],
                'fieldConfig' => [
                    'template' => "{input}",
                ],
            ]);?>
            <p class="title">Оставьте Ваш телефон и Мы перезвоним Вам в течении 5 минут!</p>
            <?= $form->field($modelGetContacts, 'phone')->widget(MaskedInput::className(), [
                'mask' => '+7(999)999-99-99',
                'options'=>[
                    'class'=>'input',
                    'placeholder'=>'Введите Ваш телефон'
                ]
            ]); ?>
            <button>Подписаться</button>
            <?php ActiveForm::end()?>

            <div class="social">
                <a href="" class="icon vk"></a>
                <a href="" class="icon fb"></a>
                <a href="" class="icon in"></a>
                <a href="" class="icon vb"></a>
            </div>
            <div class="phones">
                <a href="tel:80996611783" itemprop="telephone">8 (099) 661-17-83</a>
                <a href="tel:80996611783" itemprop="telephone">8 (099) 661-17-83</a>
            </div>
            <img src="<?=Yii::getAlias('@web/images/logo.png')?>" alt="Всё для танцев" class="logo" />
        </div>
        <div class="footer-dev">
            &copy; <?=date('Y')=='2017'?'2017':'2017-'.date('Y')?> Все права защищены, интернет магазин «Нарядница». Сайт разработал и продвинул: <a href="">Vad0k</a>
        </div>
    </div>
    <div itemscope itemtype="http://schema.org/Organization">
        <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
            <meta itemprop="addressCountry " content="Россия" />
            <meta itemprop="addressRegion" content="Крым" />
            <meta itemprop="addressLocality" content="Симферополь" />
            <meta itemprop="streetAddress" content="ул.Тренева, 1" />
            <meta itemprop="postalCode" content="295053" />
        </div>
        <meta itemprop="name" content="Милонга" />
    </div>

</footer>
<!-- ПОДВАЛ САЙТА -->

<!-- КОРЗИНА -->
<?php Modal::begin([
    'header'=>'<h2 class="title">Ваша корзина</h2>',
    'id'=>'basket-cart',
    'size'=>'modal-lg',
    'footer'=>'
        <button class="btn btn-default" data-dismiss="modal">Продолжить покупки</button>
        <a href="'.(Url::to(['basket/clear-basket'])).'" class="btn btn-danger clear-basket">Очистить корзину</a>
        <a href="'.(Url::to(['basket/order'])).'" class="btn btn-success">Перейти к оформлению</a>
    '
])?>
<?php Modal::end()?>
<!-- КОРЗИНА -->

<!-- ПРОИЗВОЛЬНОЕ СООБЩЕНИЕ -->
<?php Modal::begin([
    'header'=>'<h2 class="title"></h2>',
    'id'=>'simple-alert',
    'size'=>'modal-lg',
    'footer'=>'<button class="btn btn-default" data-dismiss="modal">Закрыть</button>'
])?>
<?php Modal::end()?>
<!-- ПРОИЗВОЛЬНОЕ СООБЩЕНИЕ -->
