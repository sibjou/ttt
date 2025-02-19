<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;

$this->registerCssFile('@web/css/style.css'); // Подключение стилей

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <link rel="icon" type="image/png" href="<?= Yii::getAlias('@web') ?>/favicon.png">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrapper"> <!-- Добавлен общий контейнер -->

    <nav class="site-nav">
        <ul class="navbar-nav">
            <!-- Логотип -->
            <li class="logo-item">
                <a href="<?= Yii::$app->homeUrl ?>" class="logo-link">
                    <img src="<?= Yii::getAlias('@web') ?>/images/new-logo255-66.png" alt="Логотип сайта" class="site-logo">
                </a>
            </li>
            <!-- Основное меню -->
            <?= Nav::widget([
                'options' => ['class' => 'navbar-nav'],
                'items' => [
                    [
                        'label' => 'Главная',
                        'url' => ['/site/index'],
                        'linkOptions' => Yii::$app->controller->id === 'site' && Yii::$app->controller->action->id === 'index'
                            ? ['class' => 'active']
                            : [],
                    ],
                    [
                        'label' => 'Добавить результат',
                        'url' => ['/site/results'],
                        'linkOptions' => Yii::$app->controller->id === 'site' && Yii::$app->controller->action->id === 'results'
                            ? ['class' => 'active']
                            : [],
                    ],
                    [
                        'label' => 'Обзоры',
                        'url' => ['/reviews'],
                        'linkOptions' => Yii::$app->controller->id === 'site' && Yii::$app->controller->action->id === 'reviews'
                            ? ['class' => 'active']
                            : [],
                    ],
                    [
                        'label' => 'Игроки',
                        'url' => ['/site/players'],
                        'linkOptions' => Yii::$app->controller->id === 'site' && Yii::$app->controller->action->id === 'players'
                            ? ['class' => 'active']
                            : [],
                    ],
                    [
                        'label' => 'Турниры',
                        'url' => ['/site/tournaments'],
                        'linkOptions' => Yii::$app->controller->id === 'site' && Yii::$app->controller->action->id === 'tournaments'
                            ? ['class' => 'active']
                            : [],
                    ],
                    // Проверка на доступ для администратора
                    Yii::$app->user->identity && Yii::$app->user->identity->isAdmin() ? (
                        [
                            'label' => 'Администрирование',
                            'url' => '#',
                            'linkOptions' => [
                                'class' => 'admin-dropdown-toggle',
                            ],
                            'options' => ['class' => 'dropdown'],
                            'template' => '<a href="#" class="admin-dropdown-toggle">{label}</a>',
                            'items' => array_filter([
                                [
                                    'label' => 'Управление пользователями',
                                    'url' => ['/admin/users'],
                                ],
                                [
                                    'label' => 'Обновление рейтингов',
                                    'url' => ['/admin/rating'],
                                ],
                                // Кнопка для управления новостями только для суперадминистратора
                                Yii::$app->user->identity->isSuperAdmin() ? [
                                    'label' => 'Управление новостями',
                                    'url' => ['/admin/news'],
                                ] : null,
                            ]),
                        ]
                    ) : '',
                    Yii::$app->user->isGuest ? (
                        [
                            'label' => 'Вход',
                            'url' => ['/site/login'],
                            'linkOptions' => Yii::$app->controller->id === 'site' && Yii::$app->controller->action->id === 'login'
                                ? ['class' => 'active']
                                : [],
                        ]
                    ) : (
                        '<li>' .
                        Html::beginForm(['/site/logout'], 'post', ['class' => 'logout-form']) .
                        Html::submitButton(
                            'Выход (' . Yii::$app->user->identity->username . ')',
                            ['class' => 'btn btn-link logout-button']
                        ) .
                        Html::endForm() .
                        '</li>'
                    ),
                    Yii::$app->user->isGuest ? (
                        [
                            'label' => 'Регистрация',
                            'url' => ['/site/signup'],
                            'linkOptions' => Yii::$app->controller->id === 'site' && Yii::$app->controller->action->id === 'signup'
                                ? ['class' => 'active']
                                : [],
                        ]
                    ) : '',
                ],
            ]) ?>

        </ul>
    </nav>

    <main class="container"> <!-- Заменили div на main -->
        <?= $content ?>
    </main>
</div>

<footer class="footer">
    <div class="container">
        <p>&copy; TTracker by Krupenia Mikhail <?= date('Y') ?></p>
    </div>
</footer>

<!-- JavaScript для раскрытия/скрытия подменю -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const dropdowns = document.querySelectorAll('.admin-dropdown-toggle');

        dropdowns.forEach(dropdown => {
            dropdown.addEventListener('click', (e) => {
                e.preventDefault(); // Предотвращаем переход по ссылке
                const parent = dropdown.parentElement;
                const submenu = parent.querySelector('ul');

                if (submenu) {
                    submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
                }
            });
        });

        // Скрываем все подменю по умолчанию
        const submenus = document.querySelectorAll('.dropdown ul');
        submenus.forEach(submenu => {
            submenu.style.display = 'none';
        });
    });
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
