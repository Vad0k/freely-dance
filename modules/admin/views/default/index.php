<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

if(Yii::$app->user->isGuest):?>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'action'=>Url::to(['/admin/default/login'])
    ]); ?>

    <?= $form->field($modelLoginForm, 'username')->textInput(['autofocus' => true]) ?>

    <?= $form->field($modelLoginForm, 'password')->passwordInput() ?>


    <div class="form-group">
        <?= $form->field($modelLoginForm, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>
        <?= Html::submitButton('Авторизоваться', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

    </div>

    <?php ActiveForm::end(); ?>

<?php else:?>
    <h1>Вы авторизованы!</h1>
<?php endif;?>