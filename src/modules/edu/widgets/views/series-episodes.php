<?php
declare(strict_types=1);

use yii\helpers\Html;

/**
 * @var string $slug
 * @var array $episodes
 */
?>

<?php if ($episodes) : ?>
    <ol class="series-episodes">
        <?php foreach ($episodes as $episode) : ?>
            <li>
                <?php if ($episode['public']) : ?>
                <a href="https://deworker.pro/edu/series/<?= Html::encode($slug . '/' . $episode['slug']) ?>" target="_blank">
                    <?= Html::encode($episode['title']) ?>
                </a>
                <?php else : ?>
                    Скоро: <?= Html::encode($episode['title']) ?>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ol>
<?php endif; ?>
