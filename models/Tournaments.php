<?php

namespace app\models;

use yii\db\ActiveRecord;

class Tournament extends ActiveRecord
{
    /**
     * Указываем таблицу, с которой связана модель.
     */
    public static function tableName()
    {
        return 'tournament'; // Имя таблицы в вашей базе данных
    }

    /**
     * Определяем правила валидации для атрибутов.
     */
    public function rules()
    {
        return [
            [['date', 'tournament_name', 'country', 'city'], 'required'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['tournament_name', 'country', 'city'], 'string', 'max' => 255],
            [['games_won', 'games_lost'], 'integer', 'min' => 0],
            [['strengths', 'weaknesses', 'mistakes', 'advantages'], 'string'],
        ];
    }

    /**
     * Подписи для атрибутов.
     */
    public function attributeLabels()
    {
        return [
            'date' => 'Дата',
            'tournament_name' => 'Название турнира',
            'country' => 'Страна',
            'city' => 'Город',
            'games_won' => 'Выиграно партий',
            'games_lost' => 'Проиграно партий',
            'strengths' => 'Сильные стороны',
            'weaknesses' => 'Слабые стороны',
            'mistakes' => 'Ошибки',
            'advantages' => 'Преимущества',
        ];
    }
}
