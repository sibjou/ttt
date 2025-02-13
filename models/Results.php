<?php

namespace app\models;

use yii\db\ActiveRecord;

class Results extends ActiveRecord
{
    /**
     * Указывает, с какой таблицей связана эта модель.
     *
     * @return string
     */
    public static function tableName()
    {
        return 'results';
    }

    /**
     * Определяет правила валидации для атрибутов.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [[ 'opponent_name', 'opponent_surname', 'games_won', 'games_lost', 'tournament_name'], 'required', 'message' => 'Это поле обязательно.'],
            [['games_won', 'games_lost'], 'integer', 'min' => 0],
            [['strengths', 'weaknesses', 'mistakes', 'advantages', 'country', 'city', 'tournament_name'], 'string'],
            [['date'], 'match', 'pattern' => '/^\d{2}\.\d{2}\.\d{4}$/', 'message' => 'Дата должна быть в формате ДД.ММ.ГГГГ.'],
            [['play_style'], 'string', 'max' => 255],
            [['hand'], 'string', 'max' => 10],
        ];
    }

    /**
     * Преобразует дату перед сохранением.
     *
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Преобразуем дату в формат Y-m-d перед сохранением
            if ($this->date && preg_match('/^\d{2}\.\d{2}\.\d{4}$/', $this->date)) {
                $this->date = \DateTime::createFromFormat('d.m.Y', $this->date)->format('Y-m-d');
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // Получаем текущую статистику пользователя
        $statistics = Statistics::findOne(['user_id' => $this->user_id]);

        if (!$statistics) {
            // Если записи нет, создаем новую
            $statistics = new Statistics();
            $statistics->user_id = $this->user_id;
            $statistics->total_games = 0;
            $statistics->total_wins = 0;
            $statistics->total_losses = 0;
            $statistics->win_rate = 0;
        }

        // Обновляем статистику
        $statistics->total_games += 1;
        $statistics->total_wins += $this->games_won;
        $statistics->total_losses += $this->games_lost;

        // Рассчитываем процент побед
        $statistics->win_rate = $statistics->total_wins / max($statistics->total_games, 1) * 100;

        // Сохраняем обновленные данные
        $statistics->save(false);
    }
}

