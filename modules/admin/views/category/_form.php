<?php

use kartik\depdrop\DepDrop;
use mihaildev\elfinder\InputFile;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\ModelCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="model-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'parent_id')->dropDownList(ArrayHelper::map(\app\models\ModelCategory::find()->where(['visible'=>1])->all(),'id','label'),['prompt' => 'Укажите автора записи']);?>

    <?= $form->field($model, 'label_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList([
        'CATEGORY'=>'Категория',
        'SUB-CATEGORY'=>'Подкатегория',
        'PRODUCT'=>'Товар',
        'PAGE'=>'Независимая страница'

    ]) ?>

    <?= $form->field($model, 'image')->widget(InputFile::className(), [
        'language'      => 'ru',
        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options'       => ['class' => 'form-control'],
        'buttonOptions' => ['class' => 'btn btn-default'],
        'multiple'      => false       // возможность выбора нескольких файлов
    ]);?>

    <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bgSize')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'article')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'head_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'head_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'head_keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'visible')->radioList([
        '0'=>'Скрыть',
        '1'=>'Опубликовать',
    ]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Созадть категорию' : 'Изменить категорию', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
