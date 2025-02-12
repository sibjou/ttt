<?php
use yii\helpers\Html;

$this->title = 'Игроки';
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Пользователь</th>
                <th>Всего игр</th>
                <th>Побед в партиях</th>
                <th>Поражений в партиях</th>
                <th>Процент побед</th>
                <th>Рейтинг</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($statistics as $stat): ?>
                <tr>
                    <td><?= Html::encode($stat->user->username ?? 'Неизвестно') ?></td>
                    <td><?= Html::encode($stat->total_games) ?></td>
                    <td><?= Html::encode($stat->total_wins) ?></td>
                    <td><?= Html::encode($stat->total_losses) ?></td>
                    <td><?= Html::encode(number_format($stat->win_rate, 2)) ?>%</td>
                    <td><?= Html::encode($stat->user->rating ?? 'Нет данных') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

