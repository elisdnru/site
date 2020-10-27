<?php

use app\modules\user\models\Access;
use yii\helpers\Html;
use yii\web\View;

/** @var $this View */
/** @var $series array */

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
            Каждую неделю записываю интересные видео по программироваю на моём втором проекте скринкастов
            <a href="https://deworker.pro/edu" target="_blank" rel="noopener">deworker.pro</a> в сериях:
        </p>

        <div class="edu-items">
            <div class="edu-items-wrapper">
                <?php foreach ($series as $item) : ?>
                    <div class="edu-items-item">
                        <div class="edu-items-item-wrapper">
                            <div class="thumb-wrapper">
                                <a href="https://deworker.pro/edu/series/<?= Html::encode($item['slug']) ?>"
                                   class="thumb" target="_blank" rel="noopener">
                                    <img src="<?= Html::encode($item['thumbnail']) ?>" alt="" />
                                </a>
                            </div>
                            <div class="body">
                                <div class="title">
                                    <a
                                        href="https://deworker.pro/edu/series/<?= Html::encode($item['slug']) ?>"
                                        target="_blank" rel="noopener"
                                    >
                                        <?= Html::encode($item['title']) ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="edu-all-link">
            <a href="https://deworker.pro/edu" target="_blank" rel="noopener">Все эпизоды &rarr;</a>
        </div>
    </div>
</section>
