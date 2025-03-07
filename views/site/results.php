<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Добавить результат';
?>
<h1><?= Html::encode($this->title) ?></h1>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<p>Пожалуйста, заполните форму для добавления результата:</p>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'date')->textInput(['placeholder' => 'ДД.ММ.ГГГГ', 'type' => 'text'])->label('Дата') ?>
<?= $form->field($model, 'opponent_name')->textInput(['placeholder' => 'Введите имя соперника'])->label('Имя соперника') ?>
<?= $form->field($model, 'opponent_surname')->textInput(['placeholder' => 'Введите фамилию соперника'])->label('Фамилия соперника') ?>
<?= $form->field($model, 'games_won')->input('number', ['min' => 0])->label('Количество выигранных партий') ?>
<?= $form->field($model, 'games_lost')->input('number', ['min' => 0])->label('Количество проигранных партий') ?>
<?= $form->field($model, 'strengths')->textarea(['rows' => 3])->label('Сильные стороны соперника') ?>
<?= $form->field($model, 'weaknesses')->textarea(['rows' => 3])->label('Слабые стороны соперника') ?>
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

<!-- Новые поля -->
<?= $form->field($model, 'country')->dropDownList([
    'Россия' => 'Россия',
    'США' => 'США',
    'Германия' => 'Германия',
    'Китай' => 'Китай'
], [
    'prompt' => 'Выберите страну',
    'options' => [
        $lastCountry => ['Selected' => true], // Предложение последней выбранной страны
    ],
])->label('Страна') ?>

<?= $form->field($model, 'city')->textInput([
    'value' => $lastCity, // Предложение последнего выбранного города
    'placeholder' => 'Введите город',
])->label('Город') ?>

<?= $form->field($model, 'tournament_name')->textInput([
    'value' => $lastTournament, // Предложение последнего введенного значения
    'placeholder' => 'Введите название турнира (или место проведения)',
])->label('Название турнира') ?>

<div class="form-group">
    <?= Html::submitButton('Добавить результат', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
