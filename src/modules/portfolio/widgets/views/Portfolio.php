<?php declare(strict_types=1);

use app\modules\portfolio\models\Work;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var Work[] $items
 */
?>

<div class="portfolio ribbed">
    <div class="carousel-link carousel-prev-link"></div>
    <div class="carousel-link carousel-next-link"></div>
    <div class="portfolio-slider">
        <ul>
            <?php foreach ($items as $item) : ?>
                <li>
                    <a rel="nofollow" href="<?= Url::to([
                        '/portfolio/work/show',
                        'category' => $item->category->getPath(),
                        'id' => $item->id,
                        'slug' => $item->slug,
                    ]); ?>">
                        <span class="thumb" style="background-image: url('<?= $item->getImageThumbUrl(190, 0); ?>')">
                            <span><?= Html::encode($item->title); ?></span>
                        </span>
                    </a>
                </li>
            <?php endforeach; ?>
            <li class="more">
                <a rel="nofollow" href="<?= Url::to(['/portfolio/default/index']); ?>">
                    <span class="thumb"></span>
                </a>
            </li>
        </ul>
    </div>
</div>
