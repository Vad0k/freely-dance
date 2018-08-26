<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\components\WidgetAsideLeft;
use app\components\WidgetFooter;
use app\components\WidgetHeaderNav;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\widgets\Pjax;

//use SchemaBreadcrumbs\SchemaBreadcrumbs as Breadcrumbs;

AppAsset::register($this);
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

<?php Pjax::begin([
    'id'=>'my-site',
    'scrollTo'=>0
]);?>
<?=WidgetHeaderNav::widget();?>
<div class="container">
    <?= Breadcrumbs::widget([
        'itemTemplate' => "<li><span>{link}</span></li>\n",
        'homeLink' => [
            'label' => 'Главная',
            'url' => Url::to(['site/index']),
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]);
    ?>
    <?//=WidgetAsideLeft::widget();?>
    <?= $content ?>
</div>
<?php Pjax::end();?>


<?=WidgetFooter::widget();?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
