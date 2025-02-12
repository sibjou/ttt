<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
?>
<h1><?= Html::encode($this->title) ?></h1>

<p>Пожалуйста, заполните поля для регистрации:</p>

<div class="signup-form">
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'email')->input('email') ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'captcha')->widget(\yii\captcha\Captcha::class, [
        'captchaAction' => 'site/captcha',
        'options' => [
            'class' => 'form-control',
            'placeholder' => 'Введите текст с картинки', // Добавляем подсказку
        ],
        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
    ]) ?>


        <div class="form-group">
            <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-success', 'name' => 'signup-button']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
