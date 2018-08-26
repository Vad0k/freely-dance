<?php

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\InputFile;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ModelProducts */
/* @var $form yii\widgets\ActiveForm */


$modelCategory = \app\models\ModelCategory::find()->where(['type'=>'PRODUCT','visible'=>1])->all();
?>

<div class="model-products-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map($modelCategory,'id','label'),['prompt' => 'Выберите категорию']) ?>

    <?= $form->field($model, 'head_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'head_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'head_keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->widget(InputFile::className(), [
        'language'      => 'ru',
        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options'       => ['class' => 'form-control'],
        'buttonOptions' => ['class' => 'btn btn-default'],
        'multiple'      => false       // возможность выбора нескольких файлов
    ]);?>
    
    <?= $form->field($model, 'bgSize')->textInput(['maxlength' => true])->label('Размер изображения: cover, containe, %, px. См. background-size (CSS).') ?>
    
    <?= $form->field($model, 'bgPosition')->textInput(['maxlength' => true])->label('Позиционирование изображения: top, left, right, bottom, center или %, px. См. background-position (CSS)') ?>

    <?= $form->field($model, 'product_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(CKEditor::className(),[
        'editorOptions' => [
            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
            'inline' => false, //по умолчанию false
        ],
    ]);?>

    <?= $form->field($model, 'description_more')->widget(CKEditor::className(),[
        'editorOptions' => [
            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
            'inline' => false, //по умолчанию false
        ],
    ]);?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'params')->textInput() ?>

	<?php $model->isFavorite = empty($model->isFavorite) ? 0 : $model->isFavorite?>
	
    <?= $form->field($model, 'isFavorite')->radioList([
        '0'=>'Не избранный товар',
        '1'=>'Считать товар как избранный',
    ]) ?>

	<?php $model->isNew = empty($model->isNew) ? 0 : $model->isNew?>
	
    <?= $form->field($model, 'isNew')->radioList([
        '0'=>'Не новинка',
        '1'=>'Пометить товар как новинка',
    ]); ?>

	<?php $model->isVisible = empty($model->isVisible) ? 1 : $model->isVisible?>
	
    <?= $form->field($model, 'isVisible')->radioList([
        '0'=>'Скрыть товар',
        '1'=>'Отобразить товар на сайте',
    ]) ?>

	
	<?php $model->views = empty($model->views) ? 0 : $model->views?>
	
    <?= $form->field($model, 'views')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'similar')->textInput() ?>

    <?= $form->field($model, 'time_created')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать товар' : 'Изменить товар', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
