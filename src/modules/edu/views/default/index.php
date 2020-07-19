<?php

use app\modules\user\models\Access;
use yii\helpers\Html;
use yii\web\View;

/** @var $this View */
/** @var $series array */
/** @var $episodes array */

$this->context->layout = 'index';

$this->title = 'База знаний';

$this->registerMetaTag([
    'name' => 'description',
    'content' => '',
]);

$this->params['breadcrumbs'] = [
    'База знаний',
];

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleManager->allowed('page')) {
        $this->params['admin'][] = ['label' => 'Страницы', 'url' => ['/page/admin/page/index']];
    }
    if (Yii::$app->moduleManager->allowed('blog')) {
        $this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post/index']];
    }
}
?>

<section>
    <h1>База знаний</h1>

    <div class="text">
        <p>
            Для более удобного выкладывания видео открыл
            <a href="https://deworker.pro/edu" target="_blank">Базу Знаний</a>
        </p>

        <div class="edu-series">
            <?php foreach ($series as $row) : ?>
                <div class="edu-series-item">
                    <div class="edu-series-item-title">
                        <a
                            href="https://deworker.pro/edu/series/<?= Html::encode($row['slug']) ?>"
                            target="_blank"
                        >
                            <?= Html::encode($row['title']) ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
