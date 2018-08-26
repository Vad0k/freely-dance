<?php
use app\assets\AppAssetAdmin;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;


AppAssetAdmin::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="container nav">
    <?php
    NavBar::begin([
        'brandLabel' => 'Milonga',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Перейти на сайт', 'url' => Url::to(['/site/index'])],
            ['label' => 'Товар', 'url' => Url::to(['/admin/product'])],
            ['label' => 'Категории', 'url' => Url::to(['/admin/category'])],

            ['label' => (Yii::$app->user->isGuest) ? 'Авторизоваться' : Yii::$app->user->identity->username.' (Выйти)', 'url'=>Yii::$app->user->isGuest ? Url::to(['/admin/default/login']) : Url::to(['/admin/default/logout'])],

        ],
    ]);
    NavBar::end();
    ?>

</div>

<div class="container">
    <?= $content ?>
</div>

<div class="footer container">
    <br/>
    <h3>+7(978)748-25-09 - по вопросам администрирования</h3>
    <br/>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
