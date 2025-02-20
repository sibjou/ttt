<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Администрирование: Обновление рейтинга';
?>
<h1><?= Html::encode($this->title) ?></h1>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'winner')->textInput(['autofocus' => true,'placeholder' => 'Введите имя победившего'])->label('Победил') ?>

<?= $form->field($model, 'loser')->textInput(['placeholder' => 'Введите имя проигравшего'])->label('Проиграл') ?>



<div class="form-group">
    <?= Html::submitButton('Обновить рейтинг', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
