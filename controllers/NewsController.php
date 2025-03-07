<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\News;

class NewsController extends Controller
{
    public function actionReviews()
    {
        $newsList = News::find()->orderBy(['created_at' => SORT_DESC])->all();
        return $this->render('reviews', ['newsList' => $newsList]);
    }

    public function actionView($slug)
    {
        $news = News::findOne(['slug' => $slug]);
        if (!$news) {
            throw new \yii\web\NotFoundHttpException('Новость не найдена.');
        }
        return $this->render('view', ['news' => $news]);
    }

}




