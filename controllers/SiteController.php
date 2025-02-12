<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Results;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['results', 'tournaments', 'players'], // Добавляем экшен players
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // Доступ только для авторизованных пользователей
                    ],
                    [
                        'allow' => false, // Запрещаем доступ для всех остальных
                        'roles' => ['?'], // Неавторизованные пользователи
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTournaments()
    {
        $results = Results::find()
            ->where(['user_id' => Yii::$app->user->id]) // Показываем только записи текущего пользователя
            ->all();

        return $this->render('tournaments', ['results' => $results]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new \app\models\SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Регистрация прошла успешно!');
            return $this->redirect(['login']);
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionResults()
    {
        $model = new Results();
        $userId = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id; // Привязка к текущему пользователю
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Результат успешно добавлен!');
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка при сохранении. Проверьте введённые данные.');
            }
        }

        // Получаем последние значения страны, города и турнира для пользователя
        $lastResult = Results::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        return $this->render('results', [
            'model' => $model,
            'lastCountry' => $lastResult->country ?? null,
            'lastCity' => $lastResult->city ?? null,
            'lastTournament' => $lastResult->tournament_name ?? null,
        ]);

        // Получаем последнее введенное название турнира для текущего пользователя
        $lastTournament = Results::find()
            ->select('tournament_name')
            ->where(['user_id' => $userId])
            ->orderBy(['id' => SORT_DESC])
            ->scalar();

        return $this->render('results', [
            'model' => $model,
            'lastTournament' => $lastTournament,
        ]);
        }


    public function actionReviews()
    {
        return $this->render('reviews');
    }

    public function actionTest()
    {
        echo Yii::t('app', 'Username');
        echo Yii::t('app', 'Password');
        exit;
    }

    public function actionPlayers()
    {
        // Получаем все записи из таблицы statistics вместе с пользователями
        $statistics = \app\models\Statistics::find()
            ->with('user') // Предзагрузка связанной модели User
            ->all();

        return $this->render('players', [
            'statistics' => $statistics,
        ]);
    }




}
