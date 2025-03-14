<?php declare(strict_types=1);

use app\modules\user\models\Access;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var array $series
 * @psalm-var array<array-key, array{
 *     slug: string,
 *     title: string,
 *     thumbnail: string,
 *     episodes: array{
 *         total: int,
 *         active: int
 *     }
 * }> $series
 * @var array $episodes
 * @psalm-var array<array-key, array{
 *     series: array{
 *         slug: string,
 *         title: string
 *     },
 *     episode: array{
 *         slug: string,
 *         title: string,
 *         short: string,
 *         thumbnail: string,
 *         free: bool
 *     }
 * }> $episodes
 */
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
    if (Yii::$app->moduleAdminAccess->isGranted('page')) {
        $this->params['admin'][] = ['label' => 'Страницы', 'url' => ['/page/admin/page/index']];
    }
    if (Yii::$app->moduleAdminAccess->isGranted('blog')) {
        $this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post/index']];
    }
}
?>

<section>
    <h1>База знаний</h1>

    <div class="text">
        <p>
            Каждую неделю записываю интересные видео по программированию на моём втором проекте скринкастов
            <a href="https://deworker.pro/edu" target="_blank" rel="noopener">deworker.pro</a> в сериях:
        </p>

        <div class="edu-items">
            <div class="edu-items-wrapper">
                <?php foreach ($series as $item): ?>
                    <div class="edu-items-item">
                        <div class="edu-items-item-wrapper">
                            <div class="thumb-wrapper">
                                <a href="https://deworker.pro/edu/series/<?= Html::encode($item['slug']); ?>"
                                   class="thumb" target="_blank" rel="noopener">
                                    <?php $imageUrl = $item['thumbnail']; ?>
                                    <picture>
                                        <source srcset="/images/lazy/blank.jpg" data-srcset="<?= $imageUrl; ?>" type="<?= FileHelper::getMimeTypeByExtension($imageUrl); ?>">
                                        <img src="/images/lazy/blank.jpg" data-src="<?= Html::encode($imageUrl); ?>" alt="" />
                                    </picture>
                                </a>
                                <span class="count" title="Готово эпизодов">
                                    <?= $item['episodes']['active']; ?> из <?= $item['episodes']['total']; ?>
                                </span>
                            </div>
                            <div class="body">
                                <div class="title">
                                    <a
                                        href="https://deworker.pro/edu/series/<?= Html::encode($item['slug']); ?>"
                                        target="_blank" rel="noopener"
                                    >
                                        <?= Html::encode($item['title']); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <br />

        <h2>Свежие эпизоды</h2>

        <br />

        <div class="edu-items">
            <div class="edu-items-wrapper">
                <?php foreach ($episodes as $item): ?>
                    <div class="edu-items-item">
                        <div class="edu-items-item-wrapper">
                            <div class="thumb-wrapper">
                                <a href="https://deworker.pro/edu/series/<?= Html::encode($item['series']['slug']); ?>/<?= Html::encode($item['episode']['slug']); ?>"
                                   class="thumb" target="_blank" rel="noopener">
                                    <?php $imageUrl = $item['episode']['thumbnail']; ?>
                                    <picture>
                                        <source srcset="/images/lazy/blank.jpg" data-srcset="<?= $imageUrl; ?>" type="<?= FileHelper::getMimeTypeByExtension($imageUrl); ?>">
                                        <img src="/images/lazy/blank.jpg" data-src="<?= Html::encode($imageUrl); ?>" alt="" />
                                    </picture>
                                </a>
                            </div>
                            <div class="body">
                                <div class="series">
                                    <a href="https://deworker.pro/edu/series/<?= Html::encode($item['series']['slug']); ?>" target="_blank" rel="noopener">
                                        <?= Html::encode($item['series']['title']); ?>
                                    </a>
                                </div>
                                <div class="title">
                                    <span class="index">62&nbsp;</span>
                                    <a
                                        href="https://deworker.pro/edu/series/<?= Html::encode($item['series']['slug']); ?>/<?= Html::encode($item['episode']['slug']); ?>"
                                        target="_blank" rel="noopener"
                                    >
                                        <?= Html::encode($item['episode']['title']); ?>
                                    </a>
                                </div>
                                <div class="description">
                                    <?= Html::encode($item['episode']['short']); ?>
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
