<?php 
use yii\helpers\Html;

/** @var $newsList \app\models\News[] */

$this->title = 'Обзоры';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <div class="masonry-grid">
        <?php if (!empty($newsList)): ?>
            <?php foreach ($newsList as $news): ?>
                <div class="grid-item">
                    <a href="/news/view?slug=<?= Html::encode($news->slug) ?>">
                        <img src="<?= Html::encode($news->image) ?>" alt="<?= Html::encode($news->title) ?>">
                        <h3><?= Html::encode($news->title) ?></h3>
                        <p><?= Html::encode($news->description) ?></p>
                    </a>
                    <div class="tags">
                        <?php foreach (explode(',', $news->tags) as $tag): ?>
                            <span class="tag"><?= Html::encode($tag) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Новостей пока нет.</p>
        <?php endif; ?>
    </div>
</body>
</html>
