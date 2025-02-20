<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Управление пользователями';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel, // Модель поиска
        'tableOptions' => ['class' => 'table table-bordered'], // Добавляем класс для стилей таблицы
        'columns' => [
            // Поле "Имя пользователя" с поиском и подсказкой
            [
                'attribute' => 'username',
                'label' => 'Имя пользователя',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => 'Введите имя пользователя для поиска', // Подсказка
                ],
            ],
            // Поле "Роль" с сортировкой
            [
                'attribute' => 'role',
                'label' => 'Роль',
                'visible' => Yii::$app->user->identity->isSuperAdmin(),
            ],
            // Поле "Назначил" с сортировкой
            [
                'attribute' => 'granted_by',
                'label' => 'Назначил',
                'value' => function ($model) {
                    return $model->granted_by ? ($model->grantedBy->username ?? 'Система') : 'Система';
                },
                'visible' => Yii::$app->user->identity->isSuperAdmin(),
                'enableSorting' => true, // Включаем сортировку
            ],
            // Кнопки действий
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{make-admin} {revoke-admin}',
                'buttons' => [
                    'make-admin' => function ($url, $model, $key) {
                        if ($model->role !== 'admin') {
                            return Html::a('Назначить', ['make-admin', 'id' => $model->id], [
                                'class' => 'btn btn-success btn-sm',
                                'data-confirm' => 'Вы уверены, что хотите назначить администратора?',
                            ]);
                        }
                        return null;
                    },
                    'revoke-admin' => function ($url, $model, $key) {
                        if ($model->role === 'admin' && (Yii::$app->user->identity->isSuperAdmin() || $model->granted_by === Yii::$app->user->id)) {
                            return Html::a('Отозвать', ['revoke-admin', 'id' => $model->id], [
                                'class' => 'btn btn-danger btn-sm',
                                'data-confirm' => 'Вы уверены, что хотите отозвать права администратора?',
                            ]);
                        }
                        return null;
                    },
                ],
            ],
        ],
    ]); ?>
</div>
