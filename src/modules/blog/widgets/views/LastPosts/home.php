<?php
use app\components\DateFormatter;
use yii\helpers\Html;

/** @var $posts \app\modules\blog\models\Post[] */
?>
<?php foreach ($posts as $data) : ?>
    <?php
    $links = [];
    foreach ($data->tags as $tag) {
        $links[] = '<a href="' . Html::encode($tag->getUrl()) . '">' . Html::encode($tag->title) . '</a>';
    }
    ?>

    <div class="entry list">
        <div class="header">
            <div class="title"><a href="<?= $data->getUrl() ?>"><?= Html::encode($data->title) ?></a></div>
            <!--noindex-->
            <div class="info">
                <div class="date">
                    <span class="enc-date" data-date="<?= DateFormatter::format($data->date) ?>">&nbsp;</span>
                </div>
                <?php if ($data->category) : ?>
                    <div class="category">
                        <span><a href="<?= $data->category->getUrl() ?>"><?= Html::encode($data->category->title) ?></a></span>
                    </div>
                <?php endif; ?>
                <div class="tags"><span><?= implode(', ', $links) ?></span></div>
                <div class="comments">
                    <span><?= $data->getCommentsCount() ?></span>
                </div>
            </div>
            <?php if ($data->image) : ?>
                <?php $imageUrl = $data->getImageThumbUrl(250); ?>
                <?php
                $properties = [
                    'data-src' => $imageUrl
                ];
                if ($data->image_width) {
                    $properties['width'] = $data->image_width;
                }
                if ($data->image_height) {
                    $properties['height'] = $data->image_height;
                }
                ?>
                <div class="thumb">
                    <a href="<?= $data->getUrl() ?>">
                        <picture>
                            <source srcset="/images/lazy/blank.webp" data-srcset="<?= $imageUrl ?>.webp" type="image/webp">
                            <source srcset="/images/lazy/blank.jpg" data-srcset="<?= $imageUrl ?>" type="image/jpeg">
                            <?= Html::img($imageUrl, $properties) ?>
                        </picture>
                    </a>
                </div>
            <?php endif; ?>
            <!--/noindex-->
        </div>
        <div class="short"><?= trim($data->short_purified) ?></div>
    </div>

<?php endforeach; ?>
