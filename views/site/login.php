<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Login');
?>
<h1><?= Html::encode($this->title) ?></h1>

<p><?= Yii::t('app', 'Please fill out the following fields to login:') ?></p>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput(['autofocus' => true])->label(Yii::t('app', 'Email')) ?>

    <?= $form->field($model, 'password')->passwordInput()->label(Yii::t('app', 'Password')) ?>

    <?= $form->field($model, 'rememberMe')->checkbox()->label(Yii::t('app', 'Remember Me')) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>

<?php ActiveForm::end(); ?>
