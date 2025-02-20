<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактировать запись';
?>
<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(); ?>


<?= $form->field($model, 'opponent_name')->textInput()->label('Имя соперника') ?>
<?= $form->field($model, 'opponent_surname')->textInput()->label('Фамилия соперника') ?>
<?= $form->field($model, 'games_won')->input('number', ['min' => 0])->label('Выиграно партий') ?>
<?= $form->field($model, 'games_lost')->input('number', ['min' => 0])->label('Проиграно партий') ?>
<?= $form->field($model, 'strengths')->textarea(['rows' => 3])->label('Сильные стороны противника') ?>
<?= $form->field($model, 'weaknesses')->textarea(['rows' => 3])->label('Слабые стороны противника') ?>
<?= $form->field($model, 'mistakes')->textarea(['rows' => 3])->label('Ваши ошибки') ?>
<?= $form->field($model, 'advantages')->textarea(['rows' => 3])->label('Ваши преимущества') ?>
<?= $form->field($model, 'play_style')->dropDownList([
    'attacker' => 'Атакующий',
    'defending' => 'Защищающийся',
    'combined' => 'Комбинированный',
], ['prompt' => '--Выберите стиль игры--'])->label('Стиль игры соперника') ?>
<?= $form->field($model, 'hand')->radioList([
    'right' => 'Правой рукой',
    'left' => 'Левой рукой',
])->label('Доминирующая рука соперника') ?>
<?= $form->field($model, 'country')->textInput()->label('Страна') ?>
<?= $form->field($model, 'city')->textInput()->label('Город') ?>
<?= $form->field($model, 'tournament_name')->textInput()->label('Название турнира') ?>

<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
