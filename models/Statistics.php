<?php

namespace app\models;

use yii\db\ActiveRecord;

class Statistics extends ActiveRecord
{
    /**
     * Указывает таблицу, с которой связана модель.
     *
     * @return string
     */
    public static function tableName()
    {
        return 'statistics';
    }

    /**
     * Правила валидации для модели.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['user_id', 'total_games', 'total_wins', 'total_losses'], 'integer'],
            [['win_rate'], 'number'],
            [['user_id'], 'required'],
        ];
    }

    /**
     * Подписи атрибутов (для отображения в формах и сообщениях об ошибках).
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'ID Пользователя',
            'total_games' => 'Всего игр',
            'total_wins' => 'Всего побед',
            'total_losses' => 'Всего поражений',
            'win_rate' => 'Процент побед',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(\app\models\User::class, ['id' => 'user_id']);
    }

}

