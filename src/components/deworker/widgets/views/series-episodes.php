<?php
declare(strict_types=1);
/**
 * @var $slug string
 * @var $episodes array
 */
use yii\helpers\Html;
?>

<?php if ($episodes) : ?>
    <ol>
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
