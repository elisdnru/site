<?php

declare(strict_types=1);

use yii\helpers\FileHelper;
use yii\helpers\Html;

/**
 * @var string $slug
 * @var array $episodes
 * @psalm-var array<array-key, array{
 *     series: array{
 *         slug: string
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
?>

<?php if ($episodes) : ?>
    <div class="edu-items">
        <div class="edu-items-wrapper">
            <?php foreach ($episodes as $item) : ?>
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
                                <svg class="play" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                     viewBox="0 0 58 58" xml:space="preserve">
                                    <circle cx="29" cy="29" r="29"/>
                                    <g>
                                        <polygon style="fill:#FFFFFF;" points="44,29 22,44 22,29.273 22,14"/>
                                        <path style="fill:#FFFFFF;" d="M22,45c-0.16,0-0.321-0.038-0.467-0.116C21.205,44.711,21,44.371,21,44V14
            c0-0.371,0.205-0.711,0.533-0.884c0.328-0.174,0.724-0.15,1.031,0.058l22,15C44.836,28.36,45,28.669,45,29s-0.164,0.64-0.437,0.826
            l-22,15C22.394,44.941,22.197,45,22,45z M23,15.893v26.215L42.225,29L23,15.893z"/>
                                    </g>
                                </svg>
                            </a>
                            <?php if ($item['episode']['free']) : ?>
                                <span class="badges"><span class="badge free">Free</span></span>
                            <?php endif; ?>
                        </div>
                        <div class="body">
                            <div class="title">
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
<?php endif; ?>
