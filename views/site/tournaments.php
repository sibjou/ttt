<?php
use yii\helpers\Html;

$this->title = 'Ваши записи';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
    <!-- Поле поиска -->
    <input type="text" id="search-input" class="form-control" placeholder="Поиск по записям..." style="flex: 1; max-width: 300px;">
    <!-- Кнопка фильтра -->
    <button id="filter-button" class="btn btn-primary">Фильтр</button>
</div>

<div id="filter-options" style="display: none; margin-top: 10px;">
    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
        <!-- Сортировка -->
        <button id="sort-date-button" class="btn btn-secondary">Сортировать по дате</button>
        <button id="sort-name-button" class="btn btn-secondary">Сортировать по фамилии</button>

        <!-- Фильтры -->
        <div>
            <button id="filter-tournament-button" class="btn btn-secondary">Турнир</button>
            <div id="tournament-options" style="display: none; margin-top: 5px;">
                <select id="filter-tournament" class="form-control">
                    <option value="">Все турниры</option>
                    <?php foreach (array_unique(array_column($results, 'tournament_name')) as $tournament): ?>
                        <option value="<?= Html::encode($tournament) ?>"><?= Html::encode($tournament) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div>
            <button id="filter-country-button" class="btn btn-secondary">Страна</button>
            <div id="country-options" style="display: none; margin-top: 5px;">
                <select id="filter-country" class="form-control">
                    <option value="">Все страны</option>
                    <?php foreach (array_unique(array_column($results, 'country')) as $country): ?>
                        <option value="<?= Html::encode($country) ?>"><?= Html::encode($country) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div>
            <button id="filter-city-button" class="btn btn-secondary">Город</button>
            <div id="city-options" style="display: none; margin-top: 5px;">
                <select id="filter-city" class="form-control">
                    <option value="">Все города</option>
                    <?php foreach (array_unique(array_column($results, 'city')) as $city): ?>
                        <option value="<?= Html::encode($city) ?>"><?= Html::encode($city) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button id="apply-filters" class="btn btn-success" style="margin-top: 5px;">Применить</button>
    </div>
</div>

<ul id="results-list">
    <?php foreach ($results as $result): ?>
        <li class="result-item" 
            data-date="<?= Html::encode($result->date) ?>"
            data-surname="<?= Html::encode($result->opponent_surname) ?>"
            data-tournament="<?= Html::encode($result->tournament_name) ?>" 
            data-country="<?= Html::encode($result->country) ?>" 
            data-city="<?= Html::encode($result->city) ?>"
            onclick="toggleDetails(this)">
            <strong><?= Html::encode($result->date) ?>: <?= Html::encode($result->opponent_name) ?> <?= Html::encode($result->opponent_surname) ?></strong>
            <div class="details" style="display:none;">
                <p><strong>Выиграно партий:</strong> <?= Html::encode($result->games_won) ?></p>
                <p><strong>Проиграно партий:</strong> <?= Html::encode($result->games_lost) ?></p>
                <p><strong>Сильные стороны противника:</strong> <?= Html::encode($result->strengths) ?></p>
                <p><strong>Слабые стороны противника:</strong> <?= Html::encode($result->weaknesses) ?></p>
                <p><strong>Мои ошибки:</strong> <?= Html::encode($result->mistakes) ?></p>
                <p><strong>Мои преимущества:</strong> <?= Html::encode($result->advantages) ?></p>
                <p><strong>Стиль игры:</strong> <?= Html::encode(Yii::t('app', $result->play_style)) ?></p>
                <p><strong>Рука:</strong> <?= Html::encode(Yii::t('app', $result->hand)) ?></p>
                <p><strong>Страна:</strong> <?= Html::encode($result->country) ?></p>
                <p><strong>Город:</strong> <?= Html::encode($result->city) ?></p>
                <p><strong>Название турнира:</strong> <?= Html::encode($result->tournament_name) ?></p>
            </div>
            <div class="actions">
                <a href="<?= Yii::$app->urlManager->createUrl(['tournament/update', 'id' => $result->id]) ?>" class="btn btn-primary btn-sm">Изменить</a>
                <?= Html::a('Удалить', ['tournament/delete', 'id' => $result->id], [
                    'class' => 'btn btn-danger btn-sm',
                    'data-confirm' => 'Вы уверены, что хотите удалить эту запись?',
                    'data-method' => 'post',
                ]) ?>

            </div>
        </li>
    <?php endforeach; ?>
</ul>




