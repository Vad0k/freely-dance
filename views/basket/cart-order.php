<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

?>
<main class="main" id="cart-order">
    <article class="article">
        <h1 class="title-section">Форма оформление заказа:</h1>
        <?php $form = ActiveForm::begin([
            'id' => 'my-form-order',
            'class'=>'form',
            'action' => Url::to(['basket/confirm-order']),
            'fieldConfig' => [
                'template' => "{label}\n{input}",
            ]
            /*'enableAjaxValidation' => true,
            'validationUrl' => 'validation-rul',*/
        ]);?>
        <?=$form->field($modelOrder,'fio')->textInput(['placeholder'=>'Ваше Ф.И.О'])->label('Ваше Ф.И.О:');?>
        <div style="margin: 0 -15px;">
            <div class="col-md-3">
                <?=$form->field($modelOrder,'country')->dropDownList([
                    'Россия'=>'Россия',
                    'Украина'=>'Украина'
                ])->label('Страна:');?>
            </div>
            <?//=$form->field($modelOrder,'product_id')->hiddenInput([])?>
            <div class="col-md-3">
                <?=$form->field($modelOrder,'town')->textInput(['placeholder'=>'Симферополь'])->label('Ваш город:');?>
            </div>
            <div class="col-md-6">
                <?=$form->field($modelOrder,'street')->textInput(['placeholder'=>'Мояковского 36, кв.6'])->label('Улица:');?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?=$form->field($modelOrder,'phone')->widget(MaskedInput::className(), ['mask' => '+7(999)999-99-99'])->label('Телефон:')?>
                <?=$form->field($modelOrder,'post_index')->widget(MaskedInput::className(), [
                    'mask' => '[2]99999',
                    'options' => [
                        'placeholder'=>'295050',
                        'class'=>'form-control',
                    ],
                ])->label('Почтовый индекс:');?>
                <?=$form->field($modelOrder,'email')->widget(MaskedInput::className(), [
                    'mask' => '',
                    'clientOptions' => [
                        'alias' =>  'email'
                    ],
                    'options' => [
                        'placeholder'=>'Введите Ваш E-mail',
                        'class'=>'form-control',
                    ],
                ])->label('Email:');?>
                <?=$form->field($modelOrder,'description')->textarea(['rows'=>5,'placeholder'=>'Тут Вы можете оставить любое пожелание, просьбу для данного заказа'])->label('Примечание:');?>
                <?//=$form->field($modelOrder,'product_count')->textInput()->label('Кол-во продуктов');?>
                <?//=$form->field($modelOrder,'price')->textInput()->label('Цена');?>
            </div>
            <div class="col-md-8">
                <?=$form->field($modelOrder,'accept_politics')->checkbox(['template'=>'{input}{error}','value'=>0,'label'=>'Вы принимаете <a class="bold" href="'.Url::to(['/site/privacy-policy']).'">политику конфиденциальности</a> и ознакомились с <a class="bold" href="'.(Url::to(['site/buy-out-offer'])).'">публичной офертой</a>', 'required'=>'required']);?>
            </div>
            <div class="col-md-4" style="text-align: right;">
                <?= Html::submitInput('Оформить заказ и перейти к оплате',['class'=>'btn btn-success','data-placement'=>'top', 'data-toggle'=>'tooltip', 'title'=>'Ваша заказ будет мгновенно оформлен, после чего Вы можете его так же мгновенно оплатить. Менеджер свяжется с Вами и уточнить, когда и как будет доставлен товар.']); ?>
            </div>
        </div>


        <?php $form->end();?>

        <div class="clear"></div>
    </article>
</main>

<style>
    #my-form-order input[aria-invalid="true"]{
        border-color: #FC0000;
        color:#FFF;
    }
    #my-form-order .has-error{
        color: #FC0000!important;
    }
    .has-success,.control-label{
        color: #000!important;
        padding-bottom: 3px;
    }

</style>