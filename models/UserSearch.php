<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

class UserSearch extends User
{
    /**
     * Правила валидации для поиска.
     */
    public function rules()
    {
        return [
            [['username'], 'safe'], // Поле username для поиска
        ];
    }

    /**
     * Метод поиска.
     * @param array $params Параметры для поиска
     * @return ActiveDataProvider Провайдер данных для отображения
     */
    public function search($params)
    {
        $query = User::find();

        // Исключение текущего супер-администратора из списка
        if (\Yii::$app->user->identity->isSuperAdmin()) {
            $query->andWhere(['!=', 'id', \Yii::$app->user->id]);
        } else {
            $query->andWhere([
                'or',
                ['role' => 'user'], // Обычные пользователи
                ['granted_by' => \Yii::$app->user->id], // Пользователи, назначенные текущим администратором
            ]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        // Загрузка параметров поиска
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Применение фильтра по имени пользователя
        $query->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider;
    }
}
