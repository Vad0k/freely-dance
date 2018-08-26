<?php
use app\components\WidgetFooter;
use app\components\WidgetHeaderNav;
use app\components\WidgetHeaderSlider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

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
<?= WidgetHeaderNav::widget()?>
<?//= WidgetHeaderSlider::widget()?>
<?= Breadcrumbs::widget([
    'homeLink' => [
        'label' => 'Главная',
        'url' => Url::to(['site/index']),
    ],
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]);?>
<?= $content ?>
<?= WidgetFooter::widget()?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
