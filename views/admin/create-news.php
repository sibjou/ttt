<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\News $model */

$this->title = 'Создание новости';
?>
<div class="news-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'], // Включение загрузки файлов
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Название') ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true])->label('Slug (человеко-читаемый URL)') ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 4])->label('Описание') ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 10])->label('Полный текст') ?>

    <?= $form->field($model, 'tags')->textInput(['maxlength' => true])->label('Теги (через запятую)') ?>

    <?= $form->field($model, 'imageFile')->fileInput()->label('Главное изображение') ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

