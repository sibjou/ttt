<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Управление новостями';
?>
<h1><?= Html::encode($this->title) ?></h1>

<p><?= Html::a('Добавить новость', ['create-news'], ['class' => 'btn btn-success']) ?></p>

<div class="table-responsive"> <!-- Контейнер для горизонтальной прокрутки -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 'header' => '№'], // Нумерация
            [
                'attribute' => 'title',
                'header' => 'Заголовок', // Русский перевод
            ],
            [
                'attribute' => 'description',
                'header' => 'Описание', // Русский перевод
                'contentOptions' => ['class' => 'description-column'], // Добавляем класс для стилей
            ],
            [
                'attribute' => 'created_at',
                'header' => 'Дата создания', // Русский перевод
                'format' => 'datetime', // Формат отображения
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('Изменить', ['update-news', 'id' => $model->id], ['class' => 'btn btn-primary']);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('Удалить', ['delete-news', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data-confirm' => 'Вы уверены, что хотите удалить эту новость?',
                            'data-method' => 'post',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>


