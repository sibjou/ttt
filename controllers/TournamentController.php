<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User; // Модель для игроков, если они хранятся в таблице User
use app\models\Results; // Используем модель Results
use yii\web\NotFoundHttpException; // Для обработки ошибок, если игрок или турнир не найдены



/**
 * TournamentController
 * Этот контроллер отвечает за управление турнирами, обновление рейтингов игроков
 * и отображение информации о турнирах.
 */
class TournamentController extends Controller
{
    /**
     * Действие для отображения списка всех турниров.
     *
     * URL: /tournament/index
     */
    public function actionIndex()
    {
        // Получаем список всех турниров из базы данных
        $tournaments = Tournament::find()->all();

        // Передаём данные в представление для отображения
        return $this->render('index', [
            'tournaments' => $tournaments,
        ]);
    }

    /**
     * Действие для обновления рейтинга игроков после матча.
     *
     * URL: /tournament/update-rating
     * @param int $winnerId ID победителя матча
     * @param int $loserId ID проигравшего матча
     * @throws NotFoundHttpException Если игрок не найден
     */
    public function actionUpdateRating($winnerId, $loserId)
    {
        // Вызов метода для обновления рейтинга
        $this->updateRatings($winnerId, $loserId);

        // Перенаправление обратно на список турниров
        return $this->redirect(['index']);
    }

    /**
     * Метод для обновления рейтингов игроков.
     *
     * Этот метод использует алгоритм Эло с ограничением максимального изменения рейтинга.
     *
     * @param int $winnerId ID победителя
     * @param int $loserId ID проигравшего
     * @throws NotFoundHttpException Если игроки не найдены
     */
    private function updateRatings($winnerId, $loserId)
    {
        // Константы для расчёта рейтинга
        $maxDelta = 20; // Максимальное изменение рейтинга за матч
        $kFactorStart = 40; // Коэффициент K для игроков с рейтингом < 800
        $kFactorReduced = 20; // Коэффициент K для игроков с рейтингом >= 800

        // Получение данных о победителе и проигравшем
        $winner = User::findOne($winnerId);
        $loser = User::findOne($loserId);

        // Проверяем, существуют ли оба игрока
        if (!$winner || !$loser) {
            throw new NotFoundHttpException("Игрок не найден.");
        }

        // Текущие рейтинги игроков
        $ratingWinner = $winner->rating;
        $ratingLoser = $loser->rating;

        // Определяем коэффициенты K
        $kWinner = $ratingWinner < 800 ? $kFactorStart : $kFactorReduced;
        $kLoser = $ratingLoser < 800 ? $kFactorStart : $kFactorReduced;

        // Расчет ожидания победы
        $expectedWinner = 1 / (1 + pow(10, ($ratingLoser - $ratingWinner) / 400));
        $expectedLoser = 1 - $expectedWinner;

        // Расчет изменения рейтинга с учетом ограничений
        $deltaWinner = min($kWinner * (1 - $expectedWinner), $maxDelta);
        $deltaLoser = max($kLoser * (0 - $expectedLoser), -$maxDelta);

        // Обновление рейтинга
        $winner->rating = max(0, $ratingWinner + $deltaWinner); // Убедимся, что рейтинг не уходит в отрицательные значения
        $loser->rating = max(0, $ratingLoser + $deltaLoser);

        // Сохраняем изменения
        $winner->save(false);
        $loser->save(false);

        // Логирование (опционально)
        Yii::info("Рейтинги обновлены: Победитель (ID: {$winnerId}) = {$winner->rating}, Проигравший (ID: {$loserId}) = {$loser->rating}");
    }

    public function actionAdminRating()
    {
        $model = new \yii\base\DynamicModel(['winner', 'loser']);
        $model->addRule(['winner', 'loser'], 'required')
              ->addRule(['winner', 'loser'], 'string');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $winner = User::findOne(['username' => $model->winner]);
            $loser = User::findOne(['username' => $model->loser]);

            if (!$winner || !$loser) {
                Yii::$app->session->setFlash('error', 'Один или оба игрока не найдены.');
            } else {
                $this->updateRatings($winner->id, $loser->id);
                Yii::$app->session->setFlash('success', 'Рейтинг игроков успешно обновлен.');
            }

            return $this->refresh();
        }

        return $this->render('admin-rating', ['model' => $model]);
    }


    public function actionUpdate($id)
    {
        // Находим запись по ID
        $model = Results::findOne($id);

        // Проверяем, существует ли запись и принадлежит ли она текущему пользователю
        if (!$model || $model->user_id != Yii::$app->user->id) {
            throw new \yii\web\NotFoundHttpException('Запись не найдена.');
        }

        // Если данные отправлены через форму и сохранены успешно
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Запись успешно обновлена.');
            return $this->redirect(['tournaments']); // Перенаправление на страницу списка записей
        }

        // Если форма ещё не отправлена, отображаем её
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = Results::findOne($id);

        if (!$model || $model->user_id != Yii::$app->user->id) {
            throw new NotFoundHttpException('Запись не найдена.');
        }

        $model->delete();
        Yii::$app->session->setFlash('success', 'Запись успешно удалена.');
        return $this->redirect(['tournaments']);
    }



}
