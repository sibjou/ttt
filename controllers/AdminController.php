<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\News;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use app\models\User;


class AdminController extends Controller
{
    public function behaviors()
{
    return [
        'access' => [
            'class' => \yii\filters\AccessControl::class,
            'rules' => [
                // Доступ для всех администраторов
                [
                    'allow' => true,
                    'actions' => ['users', 'make-admin', 'revoke-admin', 'rating'],
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {
                        return Yii::$app->user->identity->isAdmin();
                    },
                ],
                // Доступ только для супер-администраторов
                [
                    'allow' => true,
                    'actions' => ['create-news', 'update-news', 'delete-news', 'news'],
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {
                        return Yii::$app->user->identity->isSuperAdmin();
                    },
                ],
            ],
        ],
    ];
}


    /**
     * Отображение списка пользователей с возможностью поиска.
     */
     public function actionUsers()
        {
            $searchModel = new \app\models\UserSearch(); // Используем модель поиска
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams); // Применяем фильтры к запросу

            // Если текущий пользователь не супер-администратор
            if (!Yii::$app->user->identity->isSuperAdmin()) {
                $dataProvider->query->andWhere([
                    'or',
                    ['role' => 'user'], // Обычные пользователи
                    ['granted_by' => Yii::$app->user->id] // Администраторы, назначенные текущим пользователем
                ]);
            } else {
                // Исключаем супер-администратора из списка (самого себя)
                $dataProvider->query->andWhere(['!=', 'id', Yii::$app->user->id]);
            }

            return $this->render('users', [
                'searchModel' => $searchModel, // Передаём модель поиска
                'dataProvider' => $dataProvider, // Передаём провайдер данных
            ]);
        }



    /**
     * Назначение пользователя администратором.
     */
    public function actionMakeAdmin($id)
    {
        $user = User::findOne($id);
        if (!$user) {
            Yii::$app->session->setFlash('error', 'Пользователь не найден.');
            return $this->redirect(['users']);
        }

        $user->role = 'admin';
        $user->granted_by = Yii::$app->user->id;

        if ($user->save(false)) {
            Yii::$app->session->setFlash('success', 'Пользователь успешно назначен администратором.');
        } else {
            Yii::$app->session->setFlash('error', 'Не удалось обновить роль пользователя.');
        }

        return $this->redirect(['users']);
    }

    /**
     * Отзыв прав администратора.
     */
    public function actionRevokeAdmin($id)
    {
        $user = User::findOne($id);

        if (!$user) {
            Yii::$app->session->setFlash('error', 'Пользователь не найден.');
            return $this->redirect(['users']);
        }

        // Если текущий пользователь не супер-администратор
        if (!Yii::$app->user->identity->isSuperAdmin()) {
            // Проверяем, что текущий администратор назначил права
            if ($user->granted_by !== Yii::$app->user->id) {
                Yii::$app->session->setFlash('error', 'Вы не можете забрать права у этого пользователя.');
                return $this->redirect(['users']);
            }
        }

        // Сброс роли и удаления информации о назначившем
        $user->role = 'user';
        $user->granted_by = null;

        if ($user->save(false)) {
            Yii::$app->session->setFlash('success', 'Права администратора успешно отозваны.');
        } else {
            Yii::$app->session->setFlash('error', 'Не удалось отозвать права администратора.');
        }

        return $this->redirect(['users']);
    }
}
