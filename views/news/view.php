<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\News $news */

$this->title = $news->title;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Html::encode($this->title) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .news-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .news-title {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }
        .news-image {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .news-description {
            font-size: 16 px;
            margin-bottom: 20px;
            color: #555;
        }
        .news-text {
            font-size: 16px;
            color: #444;
            text-align: justify;
        }
        .news-tags {
            margin-top: 20px;
        }
        .news-tag {
            display: inline-block;
            background-color: #007BFF;
            color: #fff;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 16px;
            margin-right: 5px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="news-container">
        <h1 class="news-title"><?= Html::encode($news->title) ?></h1>
        <?php if ($news->image): ?>
            <img src="<?= $news->image ?>" alt="<?= Html::encode($news->title) ?>" class="news-image">
        <?php endif; ?>
        <p class="news-description"><?= Html::encode($news->description) ?></p>
        <div class="news-tags">
            <?php foreach (explode(',', $news->tags) as $tag): ?>
                <span class="news-tag"><?= Html::encode(trim($tag)) ?></span>
            <?php endforeach; ?>
        <div class="news-text"><?= nl2br(Html::encode($news->text)) ?></div>
        </div>
    </div>
</body>
</html>

