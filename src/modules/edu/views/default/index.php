<?php

use app\modules\user\models\Access;
use yii\helpers\Html;
use yii\web\View;

/** @var $this View */
/** @var $series array */
/** @var $items array */

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
        <p>Серии скринкастов:</p>

        <div class="edu-series">
            <ul>
                <?php foreach ($series as $row) : ?>
                    <li>
                        <a
                            href="https://deworker.pro/edu/series/<?= Html::encode($row['slug']) ?>"
                            target="_blank"
                        >
                            <?= Html::encode($row['title']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <p>Свежие эпизоды:</p>

        <div class="edu-items">
            <div class="edu-items-wrapper">
                <?php foreach ($items as $item) : ?>
                    <div class="edu-items-item">
                        <div class="edu-items-item-wrapper">
                            <div class="thumb-wrapper">
                                <a href="https://deworker.pro/edu/series/<?= Html::encode($item['series']['slug']) ?>/<?= Html::encode($item['episode']['slug']) ?>"
                                   class="thumb" target="_blank" rel="noopener">
                                    <img
                                        src="<?= Html::encode($item['episode']['thumbnail']) ?>"
                                        alt=""/>
                                </a>
                                <span class="badges">
                                    <?php if ($item['episode']['free']) : ?>
                                        <span class="badge free">Free</span>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <div class="body">
                                <div class="series">
                                    <a href="https://deworker.pro/edu/series/<?= Html::encode($item['series']['slug']) ?>"
                                       target="_blank" rel="noopener">
                                        <?= Html::encode($item['series']['title']) ?>
                                    </a>
                                </div>
                                <div class="title">
                                    <span class="index"><?= Html::encode($item['episode']['index']) ?></span>
                                    <a href="https://deworker.pro/edu/series/<?= Html::encode($item['series']['slug']) ?>/<?= Html::encode($item['episode']['slug']) ?>"
                                       target="_blank" rel="noopener">
                                        <?= Html::encode($item['episode']['title']) ?>
                                    </a>
                                </div>
                                <div class="description">
                                    <?= Html::encode($item['episode']['short']) ?>
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
